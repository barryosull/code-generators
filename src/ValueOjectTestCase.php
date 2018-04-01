<?php

namespace Barryosull\CodeGen;

class ValueOjectTestCase
{
    public function generateTestCase(string $valueObjectClass, array $validValuesCollection, array $invalidValuesCollection): string
    {
        $class = new \Nette\PhpGenerator\ClassType('$valueObjectClass');

        $class
            ->setFinal()
            ->setExtends('\PHPUnit\Framework\TestCase');


        $valid = $this->generateValid($class, $valueObjectClass, $validValuesCollection);

        $invalid = $this->generateInvalid($class, $valueObjectClass, $invalidValuesCollection);

        return strval($class);

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
        $provider = $this->generateProvider('validValues', $valuesCollection);

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
    public function canCreateValidTypes(...$values)
    {
        $value = new '.$valueObjectClass.'(...$values);
        $this->assertInstanceOf('.$valueObjectClass.'::class, $value);
    }

    '.$provider;

        return $templateValid;
    }

    private function generateInvalid(string $valueObjectClass, array $valuesCollection): string
    {
        $provider = $this->generateProvider('invalidValues', $valuesCollection);

        $templateValid = '    /**
     * @test
     * @dataProvider invalidValues
     */
    public function cannotCreateInvalidTypes(...$values)
    {
        $this->expectException(ValueException::class);
        new '.$valueObjectClass.'(...$values);
    }

    '.$provider;

        return $templateValid;
    }

    private function generateProvider(string $name, array $inputs): string
    {
        $function = new \Nette\PhpGenerator\Method($name);
        $function->setVisibility('public');

        $templateRows = [];
        $args = [];

        foreach ($inputs as $key=>$values) {
            $templateRows[] = "    ? => [...?],\n";
            $args[] = $key;
            $args[] = $values;
        }

        $function->setBody('return [
'.implode("", $templateRows).'];', $args);

        return str_replace("\t", "    ", strval($function));
    }
}