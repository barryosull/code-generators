<?php

namespace BarryosullTest\CodeGen\Generators;

use PHPUnit\Framework\TestCase;
use Barryosull\CodeGen\Generators\ValueOjectTestCase;

class ValueObjectTestcaseTest extends TestCase
{
    /**
     * @test
     */
    public function it_generates_a_valid_testcase()
    {
        $namespace = 'BarryosullTest\CodeGen\Generators\Generators';
        $type = 'ValueObject';
        $validValues = [
            'description a' => ['value1', 'value2', 'value3'],
            'description b' => ['value4', 'value5', 'value6'],
        ];
        $invalidValues = [
            'description a' => ['value1', 'value2'],
            'description b' => ['value4', 'value5'],
        ];

        $generator = new ValueOjectTestCase();

        $generated = $generator->generateTestCase($namespace, $type, $validValues, $invalidValues);

        $expected = file_get_contents(__DIR__ . "/Generated/ValueObjectTestGenerated.php");

        $this->assertEquals($expected, $generated);
    }
}