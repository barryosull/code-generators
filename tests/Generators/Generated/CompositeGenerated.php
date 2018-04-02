<?php

namespace BarryosullTest\CodeGen\Generators\Generators;

class CompositeGenerated
{
    private $valueA;

    private $date;

    private $address;


    public function __construct(string $valueA, \DateTime $date, \Address\Business $address)
    {
        $this->valueA = $valueA;
        $this->date = $date;
        $this->address = $address;
    }


    public function getValueA(): string
    {
        return $this->valueA;
    }


    public function getDate(): \DateTime
    {
        return $this->date;
    }


    public function getAddress(): \Address\Business
    {
        return $this->address;
    }
}
