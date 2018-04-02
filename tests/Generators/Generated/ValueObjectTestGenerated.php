<?php

namespace BarryosullTest\CodeGen\Generators\Generators;

use PHPUnit\Framework\TestCase;

class ValueObjectTest extends TestCase
{
    /**
     * @test
     * @dataProvider validValues
     */
    public function canCreateValidTypes(...$values)
    {
        $value = new ValueObject(...$values);
        $this->assertInstanceOf(ValueObject::class, $value);
    }


    public function validValues()
    {
        return [
            'description a' => ['value1', 'value2', 'value3'],
            'description b' => ['value4', 'value5', 'value6'],
        ];
    }


    /**
     * @test
     * @dataProvider invalidValues
     */
    public function cannotCreateInvalidTypes(...$values)
    {
        $this->expectException(ValueException::class);
        new ValueObject(...$values);
    }


    public function invalidValues()
    {
        return [
            'description a' => ['value1', 'value2'],
            'description b' => ['value4', 'value5'],
        ];
    }
}
