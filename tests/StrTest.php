<?php

declare(strict_types=1);

namespace SoftWaxTests\Utils;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SoftWax\Utils\Str;

class StrTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testAreEqualCaseInsensitive(
        string $string1,
        string $string2,
        bool $expectedOutput,
    ): void {
        self::assertSame($expectedOutput, Str::areEqualCaseInsensitive($string1, $string2));
    }

    public static function dataProvider(): iterable
    {
        yield [
            '',
            '',
            true,
        ];

        yield [
            '',
            ' ',
            false,
        ];

        yield [
            'ąčęėįšųūž',
            'ĄČĘĖĮŠŲŪŽ',
            true,
        ];

        yield [
            'ß',
            'ß',
            true,
        ];

        yield [
            'Τάχιστη αλώπηξ βαφής ψημένη γη, δρασκελίζει υπέρ νωθρού κυνός',
            'τάχιστη αλώπηξ βαφής ψημένη γη, δρασκελίζει υπέρ νωθρού κυνός',
            true,
        ];

        yield [
            'Mary Had A Little Lamb',
            'mary had a little LAMB',
            true,
        ];

        yield [
            'Mary Had A Little Lamb',
            ' mary had a little LAMB ',
            false,
        ];

        yield [
            'Mary  Had  A  Little  Lamb',
            'mary had a little LAMB',
            false,
        ];
    }
}
