<?php

declare(strict_types=1);

namespace SoftWaxTests\Utils;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SoftWax\Utils\Type;

class TypeTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testCoerceNonEmptyStringOrNull(mixed $input, ?string $expectedOutput): void
    {
        self::assertSame($expectedOutput, Type::coerceNonEmptyStringOrNull($input));
    }

    public static function dataProvider(): iterable
    {
        yield ['', null];

        yield [' ', null];

        yield ['AbC', 'AbC'];

        yield [1, null];

        yield [1.42, null];

        yield [true, null];

        yield [false, null];

        yield [new \stdClass(), null];

        yield [
            new class implements \Stringable
            {
                public function __toString(): string
                {
                    return 'OK';
                }
            },
            'OK',
        ];

        yield [
            new class implements \Stringable
            {
                public function __toString(): string
                {
                    return '  ';
                }
            },
            null,
        ];

        yield [
            new class implements \Stringable
            {
                public function __toString(): string
                {
                    return '';
                }
            },
            null,
        ];
    }
}
