<?php

declare(strict_types=1);

namespace SoftWax\Utils;

use function Symfony\Component\String\u;

final readonly class Str
{
    /*
     * UTF-8 aware binary safe string comparison in a case-insensitive manner.
     */
    public static function areEqualCaseInsensitive(string $string1, string $string2): bool
    {
        return $string1 === $string2
            || u($string1)->ignoreCase()->equalsTo(u($string2)->ignoreCase());
    }
}
