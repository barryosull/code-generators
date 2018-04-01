<?php

namespace BarryosullTest\CodeGen;

use PHPUnit\Framework\TestCase;
use Barryosull\CodeGen\ValueOjectTestCase;

class ValueObjectTestcaseTest extends TestCase
{
    /**
     * @test
     */
    public function it_generates_a_valid_testcase()
    {
        $type = 'ExpectedValueObject';
        $validValues = [
            'description a' => ['value1', 'value2', 'value3'],
            'description b' => ['value4', 'value5', 'value6'],
        ];
        $invalidValues = [
            'description a' => ['value1', 'value2'],
            'description b' => ['value4', 'value5'],
        ];

        $generator = new ValueOjectTestCase();

        $generated = $generator->generateTestCase($type, $validValues, $invalidValues);

        $expected = file_get_contents(__DIR__."/ExpectedValueObjectTest.php.generated");

        $this->assertEquals($expected, $generated);
    }
}