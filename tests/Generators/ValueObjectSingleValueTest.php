<?php

namespace BarryosullTest\CodeGen\Generators;

use PHPUnit\Framework\TestCase;
use Barryosull\CodeGen\Generators\ValueObject;

class ValueObjectSingleValueTest extends TestCase
{
    /**
     * @test
     */
    public function it_generates_a_valid_valueobject()
    {
        $namespace = 'BarryosullTest\CodeGen\Generators\Generators';
        $type = 'ValueObject';

        $generator = new ValueObject();

        $generated = $generator->generateSingleValue($namespace, $type);

        $expected = file_get_contents(__DIR__ . "/Generated/ValueObjectSingleValueGenerated.php");

        $this->assertEquals($expected, $generated);
    }
}