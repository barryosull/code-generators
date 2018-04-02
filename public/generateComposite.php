<?php

use Barryosull\CodeGen\Generators\Composite;

require_once __DIR__."/../vendor/autoload.php";

$classGenerator = new Composite();

$namespace= $_POST['namespace'];
$className = $_POST['className'];

$constructorArgs = [];
foreach ( explode(",", $_POST['constructorArgs']) as $argString) {
    $argString = trim($argString);
    $parts = explode(" ", $argString);

    if (count($parts) != 2) {
        throw new Exception("Invalid number of parts in param '$argString'");
    }

    $type = $parts[0];
    $value = str_replace('$', '', $parts[1]);

    $constructorArgs[$type] = $value;
}

$class = $classGenerator->generateComposite($namespace, $className, $constructorArgs);

echo "$class";