<?php

use Barryosull\CodeGen\Generators\ValueOjectTestCase;

require_once __DIR__."/../vendor/autoload.php";

$generator = new ValueOjectTestCase();

$namespace= $_POST['namespace'];
$valueObject = $_POST['valueObject'];

$validInputs = json_decode($_POST['validValues'], true);
$invalidInputs = json_decode($_POST['invalidValues'], true);

echo $generator->generateTestCase($namespace, $valueObject, $validInputs, $invalidInputs);