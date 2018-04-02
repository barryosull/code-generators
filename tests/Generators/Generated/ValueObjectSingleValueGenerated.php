<?php

namespace BarryosullTest\CodeGen\Generators\Generators;

class ValueObject
{
    private $value;

    public function __construct($value)
    {
        if ($value) {
            throw new ValueException("Invalid value of '$value'");
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
