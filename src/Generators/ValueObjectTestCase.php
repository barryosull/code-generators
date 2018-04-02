<?php

namespace Barryosull\CodeGen\Generators;

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;

/**
 * TODO: Extract out sub classes
 */
class ValueObjectTestCase
{
    public function generateTestCase(
        string $namespace,
        string $valueObjectClass,
        array $validValuesCollection,
        array $invalidValuesCollection
    ): string
    {
        $namespace = new PhpNamespace($namespace);
        $namespace->addUse('\PHPUnit\Framework\TestCase');

        $class = $namespace->addClass("{$valueObjectClass}Test");
        $class->setExtends('\PHPUnit\Framework\TestCase');

        $this->generateValid($class, $valueObjectClass, $validValuesCollection);

        $this->generateInvalid($class, $valueObjectClass, $invalidValuesCollection);

        return Formatter::format(strval($namespace));
    }

    private function generateValid(ClassType $class, string $valueObjectClass, array $valuesCollection)
    {
        $body = [
            '$value = new '.$valueObjectClass.'(...$values);',
            '$this->assertInstanceOf('.$valueObjectClass.'::class, $value);'
        ];

        $method = $class->addMethod('canCreateValidTypes')
            ->addComment('@test')
            ->addComment('@dataProvider validValues')
            ->setVisibility('public')
            ->setBody(implode("\n", $body));

        $method->setVariadic(true)
            ->addParameter('values');

        $this->generateProvider($class,'validValues', $valuesCollection);
    }

    private function generateInvalid(ClassType $class, string $valueObjectClass, array $valuesCollection)
    {
        $body = [
            '$this->expectException(ValueException::class);',
            'new '.$valueObjectClass.'(...$values);'
        ];

        $method = $class->addMethod('cannotCreateInvalidTypes')
            ->addComment('@test')
            ->addComment('@dataProvider invalidValues')
            ->setVisibility('public')
            ->setBody(implode("\n", $body));

        $method->setVariadic(true)
            ->addParameter('values');

        $this->generateProvider($class,'invalidValues', $valuesCollection);
    }

    private function generateProvider(ClassType $class, string $name, array $inputs)
    {
        $method = $class->addMethod($name);

        $templateRows = [];
        $args = [];

        foreach ($inputs as $key=>$values) {
            $templateRows[] = "    ? => [...?],\n";
            $args[] = $key;
            $args[] = $values;
        }

        $method->setBody("return [\n".implode("", $templateRows)."];", $args);
    }
}