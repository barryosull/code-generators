<?php

use Barryosull\CodeGen\Generators\Composite;
use Barryosull\CodeGen\Generators\ValueObject;
use Barryosull\CodeGen\Generators\ValueObjectTestCase;

require __DIR__.'/../vendor/autoload.php';

$app = new Slim\App();

$app->get('/', function () {
    return file_get_contents(__DIR__."/../src/templates/home.html");
});

$app->post('/composite/generate', function () {

    $classGenerator = new Composite();

    $namespace = $_POST['namespace'];
    $className = $_POST['className'];

    $constructorArgs = [];
    foreach (explode(",", $_POST['constructorArgs']) as $argString) {
        $argString = trim($argString);
        $parts = explode(" ", $argString);

        if (count($parts) != 2) {
            throw new Exception("Invalid number of parts in param '$argString'");
        }

        $type = $parts[0];
        $value = str_replace('$', '', $parts[1]);

        $constructorArgs[$type] = $value;
    }

    return $classGenerator->generateComposite($namespace, $className, $constructorArgs);
});

$app->post('/valueobject/generate', function () {
    $testGenerator = new ValueObjectTestCase();
    $classGenerator = new ValueObject();

    $namespace= $_POST['namespace'];
    $className = $_POST['className'];

    $validInputs = json_decode($_POST['validValues'], true) ?? [];
    $invalidInputs = json_decode($_POST['invalidValues'], true) ?? [];

    $testCase = $testGenerator->generateTestCase($namespace, $className, $validInputs, $invalidInputs);
    $class = $classGenerator->generateSingleValue($namespace, $className);

    return "$testCase\n\n$class";
});

$app->run();