<?php

namespace BarryosullTest\CodeGen\Generators;

use Barryosull\CodeGen\Generators\Composite;
use PHPUnit\Framework\TestCase;

class CompositeTest extends TestCase
{
    /**
     * @test
     */
    public function it_generates_a_valid_valueobject()
    {
        $namespace = 'BarryosullTest\CodeGen\Generators\Generators';
        $className = 'CompositeGenerated';
        $args = [
            'string' => 'valueA',
            'DateTime' => 'date',
            'Address\Business' => 'address'
        ];

        $generator = new Composite();

        $generated = $generator->generateComposite($namespace, $className, $args);

        $expected = file_get_contents(__DIR__ . "/Generated/CompositeGenerated.php");

        $this->assertEquals($expected, $generated);
    }
}