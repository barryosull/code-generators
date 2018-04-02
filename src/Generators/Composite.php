<?php

namespace Barryosull\CodeGen\Generators;

use Nette\PhpGenerator\PhpNamespace;

class Composite
{
    public function generateComposite(string $namespace, string $className, array $args): string
    {
        $namespace = new PhpNamespace($namespace);

        $class = $namespace->addClass($className);

        foreach ($args as $type => $property) {

            $namespace->addUse($type);

            $class->addProperty($property)
                ->setVisibility('private');
        }

        $constructor = $class->addMethod("__construct");

        $constructorBody = [];
        foreach ($args as $type => $property) {
            $constructor->addParameter($property)
                ->setTypeHint($type);

            $constructorBody[] = '$this->'.$property.' = $'.$property.';';

            $class->addMethod("get".ucfirst($property))
                ->setReturnType($type)
                ->setBody('return $this->'.$property.';');
        }

        $constructor->setBody(implode("\n", $constructorBody));

        return Formatter::format(strval($namespace));
    }
}