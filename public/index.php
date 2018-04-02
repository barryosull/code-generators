<?php

use Barryosull\CodeGen\Controllers;

require __DIR__.'/../vendor/autoload.php';

$app = new Slim\App();

$app->get('/', function () {
    return file_get_contents(__DIR__."/../src/templates/home.html");
});

$app->post('/composite/generate', Controllers\GenerateComposite::class);

$app->post('/valueobject/generate', Controllers\GenerateValueObject::class);

$app->run();