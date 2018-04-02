<?php

namespace Barryosull\CodeGen\Generators;

class ValueObject
{
    public function generateSingleValue(string $namespace, string $valueObjectClass): string
    {
        return
'<?php

namespace '.$namespace.';

class '.$valueObjectClass.'
{
    private $value;

    public function __construct($value)
    {
        if ($value) {
            throw new ValueException("Invalid value of \'$value\'");
        }
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function __toString()
    {
        return strval($this->value);
    }
}
';
    }
}