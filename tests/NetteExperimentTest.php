<?php

namespace BarryosullTest\CodeGen;

use PHPUnit\Framework\TestCase;

class NetteExperimentTest extends TestCase
{
    /**
     * @test
     */
    public function it_decompresses_variadic_args()
    {
        $inputs = [
            'values1' => [1, 2, 3],
            'values2' => [1, 2, 3],
            'values3' => [1, 2, 3],
        ];

        $actual = $this->generate($inputs);

        $expected =
'function foo()
{
    return [
        \'values1\' => [1, 2, 3],
        \'values2\' => [1, 2, 3],
        \'values3\' => [1, 2, 3],
    ];
}';

        $this->assertEquals($expected, $actual);
    }

    private function generate(array $inputs): string
    {
        $function = new \Nette\PhpGenerator\GlobalFunction('foo');

        $templateRows = [];
        $args = [];

        foreach ($inputs as $key=>$values) {
            $templateRows[] = "    ? => [...?],\n";
            $args[] = $key;
            $args[] = $values;
        }

        $function->setBody('return [
'.implode("", $templateRows).'];', $args);

        return str_replace("\t", "    ", strval($function));
    }
}