<?php

namespace Barryosull\CodeGen\Generators;

class Formatter
{
    public static function format(string $code): string
    {
        $code = self::tabsToSpaces($code);

        $code =
            "<?php

$code";

        return $code;
    }

    private static function tabsToSpaces(string $code)
    {
        return str_replace("\t", "    ", $code);
    }
}