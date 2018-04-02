<?php

namespace Barryosull\CodeGen\Controllers;

use Barryosull\CodeGen\Generators\ValueObject;
use Barryosull\CodeGen\Generators\ValueObjectTestCase;

class GenerateValueObject
{
    public function __invoke($request, $response)
    {
        $testGenerator = new ValueObjectTestCase();
        $classGenerator = new ValueObject();

        $namespace= $_POST['namespace'];
        $className = $_POST['className'];

        $validInputs = json_decode($_POST['validValues'], true) ?? [];
        $invalidInputs = json_decode($_POST['invalidValues'], true) ?? [];

        $testCase = $testGenerator->generateTestCase($namespace, $className, $validInputs, $invalidInputs);
        $class = $classGenerator->generateSingleValue($namespace, $className);

        return "$testCase\n\n$class";
    }
}