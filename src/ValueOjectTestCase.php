<?php

namespace Barryosull\CodeGen;

use Nette\PhpGenerator\ClassType;

class ValueOjectTestCase
{
    public function generateTestCase(string $valueObjectClass, array $validValuesCollection, array $invalidValuesCollection): string
    {
        $class = new ClassType("{$valueObjectClass}Test");

        $class
            ->setExtends('\PHPUnit\Framework\TestCase');

        $this->generateValid($class, $valueObjectClass, $validValuesCollection);

        $this->generateInvalid($class, $valueObjectClass, $invalidValuesCollection);

        $code = $this->tabsToSpaces(strval($class));

        $code =
"<?php

$code";

        return $code;
    }

    private function tabsToSpaces(string $code)
    {
        return str_replace("\t", "    ", $code);
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