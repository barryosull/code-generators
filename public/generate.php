<?php

use Barryosull\CodeGen\Generators\ValueObject;
use Barryosull\CodeGen\Generators\ValueObjectTestCase;

require_once __DIR__."/../vendor/autoload.php";

$testGenerator = new ValueObjectTestCase();
$classGenerator = new ValueObject();

$namespace= $_POST['namespace'];
$valueObject = $_POST['valueObject'];

$validInputs = json_decode($_POST['validValues'], true) ?? [];
$invalidInputs = json_decode($_POST['invalidValues'], true) ?? [];

$testCase = $testGenerator->generateTestCase($namespace, $valueObject, $validInputs, $invalidInputs);
$class = $classGenerator->generateSingleValue($namespace, $valueObject);

echo "$testCase\n\n$class";