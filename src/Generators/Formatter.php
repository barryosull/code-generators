<?php

namespace Barryosull\CodeGen\Generators;

class Formatter
{
    public static function format(string $code): string
    {
        $code = self::tabsToSpaces($code);

        $code = self::stripPrivatePropertyNewlines($code);

        $code = self::stripDoubleNewlines($code);

        $code =
            "<?php

$code";

        return $code;
    }

    private static function tabsToSpaces(string $code)
    {
        return str_replace("\t", "    ", $code);
    }

    private static function stripPrivatePropertyNewlines(string $code)
    {
        return str_replace(";\n\n    private", ";\n    private", $code);
    }

    private static function stripDoubleNewlines(string $code)
    {
        return str_replace("\n\n\n", "\n\n", $code);
    }
}