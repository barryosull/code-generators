<?php

namespace Barryosull\CodeGen;

class ValueOjectTestCase
{
    public function generateTestCase(string $valueObjectClass, array $validValuesCollection, array $invalidValuesCollection): string
    {
        $valid = $this->generateValid($valueObjectClass, $validValuesCollection);

        $invalid = $this->generateInvalid($valueObjectClass, $invalidValuesCollection);

        return "<?php

class {$valueObjectClass}Test extends \PHPUnit\Framework\TestCase
{
$valid

$invalid
}
";
    }

    private function generateValid(string $valueObjectClass, array $valuesCollection): string
    {
        $valuesReturn = '';
        foreach ($valuesCollection as $debugString => $values) {

            $quoteWrappedValues = array_map(function($value){
                return "'$value'";
            }, $values);

            $valuesString = implode(", ", $quoteWrappedValues);

            $valuesReturn .= "            '".$debugString."' => [$valuesString],\n";
        }

        $templateValid = '    /**
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
    }';

        return $templateValid;
    }

    private function generateInvalid(string $valueObjectClass, array $valuesCollection): string
    {
        $valuesReturn = '';
        foreach ($valuesCollection as $debugString => $values) {

            $quoteWrappedValues = array_map(function($value){
                return "'$value'";
            }, $values);

            $valuesString = implode(", ", $quoteWrappedValues);

            $valuesReturn .= "            '".$debugString."' => [$valuesString],\n";
        }

        $templateValid = '    /**
     * @test
     * @dataProvider invalidValues
     */
    public function cannotCreateInvalidTypes($valueA, $valueB)
    {
        $this->expectException(ValueException::class);
        new '.$valueObjectClass.'($valueA, $valueB);
    }

    public function invalidValues()
    {
        return [
'.$valuesReturn.'        ];
    }';

        return $templateValid;
    }
}