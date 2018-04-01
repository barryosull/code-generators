<?php

namespace Barryosull\CodeGen;

class ValueOjectTestCase
{
    public function generateValid(string $valueObjectClass, array $valuesCollection): string
    {
        $valuesReturn = '';
        foreach ($valuesCollection as $debugString => $values) {

            $quoteWrappedValues = array_map(function($value){
                return "'$value'";
            }, $values);

            $valuesString = implode(", ", $quoteWrappedValues);

            $valuesReturn .= "            '".$debugString."' => [$valuesString],\n";
        }

        $templateValid = '
    /**
     * @test
     * @dataProvider validValues
     */
    public function canCreateValidTypes($valueA, $valueB, $valueC)
    {
        $value = new '.$valueObjectClass.'($valueA, $valueB, $valueC);
        $this->assertInstanceOf('.$valueObjectClass.'::class, $value);
    }

    public function validValues()
    {
        return [
'.$valuesReturn.'        ];
    }
    ';

        return $templateValid;
    }
}