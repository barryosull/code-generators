<?php

namespace BarryosullTest\CodeGen;

use PHPUnit\Framework\TestCase;
use Barryosull\CodeGen\ValueOjectTestCase;

class ValueObjectTestcaseTest extends TestCase
{
    /**
     * @test
     */
    public function it_generates_a_valid_test_method()
    {
        $type = 'ValueObject';
        $validValues = [
            'description a' => ['value1', 'value2', 'value3'],
            'description b' => ['value4', 'value5', 'value6'],
        ];

        $generator = new ValueOjectTestCase();

        $generated = $generator->generateValid($type, $validValues);

        $this->assertEquals($this->expectedValid, $generated);
    }

    private $expectedValid = '
    /**
     * @test
     * @dataProvider validValues
     */
    public function canCreateValidTypes($valueA, $valueB, $valueC)
    {
        $value = new ValueObject($valueA, $valueB, $valueC);
        $this->assertInstanceOf(ValueObject::class, $value);
    }

    public function validValues()
    {
        return [
            \'description a\' => [\'value1\', \'value2\', \'value3\'],
            \'description b\' => [\'value4\', \'value5\', \'value6\'],
        ];
    }
    ';


    public function test_generate_invalid_tests()
    {
        return;
        $type = 'ValueObject';
        $validValues = [
            'description a' => ['value1', 'value2'],
            'description b' => ['value4', 'value5'],
        ];

        $generator = new \BarryosullTest\CodeGen\ValueOjectTestCase();

        $generated = $generator->generateInvalid($type, $validValues);

        $this->assertEquals($this->expectedInvalid, $generated);
    }

    private $expectedInvalid = '
    /**
     * @test
     * @dataProvider invalidValues
     */
    public function cannotCreateInvalidTypes($valueA, $valueB, $valueC)
    {
        $this->expectException(ValueException::class);

        new Key($valueA, $valueB, $valueC);
    }

    public function invalidValues()
    {
        return [
            \'description a\' => [\'value1\', \'value2\'],
            \'description b\' => [\'value4\', \'value5\'],
        ];
    }
    ';
}