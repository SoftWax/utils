<?php

declare(strict_types=1);

namespace SoftWaxTests\Utils;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SoftWax\Utils\Arr;

class ArrTest extends TestCase
{
    #[DataProvider('keyExistsDataProvider')]
    public function testKeyExists(array $input, string|int $key, bool $expectedOutput): void
    {
        self::assertSame($expectedOutput, Arr::keyExists($input, $key));
    }

    public static function keyExistsDataProvider(): iterable
    {
        yield [[], 1, false];
        yield [[], 'a', false];
        yield [[43 => null], 42, false];
        yield [[43 => 'testing'], 42, false];
        yield [['a' => null], 'a', true];
        yield [['a' => 3], 'a', true];
        yield [[42 => 'testing'], 42, true];
    }

    /**
     * @param iterable<mixed> $iterable
     * @param (\Closure(mixed): bool)|null $callback
     */
    #[DataProvider('filterDataProvider')]
    public function testFilter(array $expected, iterable $iterable, ?\Closure $callback = null): void
    {
        self::assertSame($expected, Arr::filter($iterable, $callback));
    }

    public static function filterDataProvider(): iterable
    {
        yield [[], []];
        yield [[1, true, 9.2], [false, 1, true, 0, null, 9.2]];
        yield [[1, true, 9.2], new \ArrayIterator([false, 1, true, 0, null, 9.2])];
        yield [['a', 'b'], ['a', 'b']];
        yield [[], ['a', 'b'], static fn (): bool => false];
        yield [['a', 'b'], ['a', 'b'], static fn (string $_): bool => true];
        yield [['a'], ['a', 'b'], static fn (string $v): bool => $v !== 'b'];
    }

    #[DataProvider('filterNullsDataProvider')]
    public function testFilterNulls(array $expected, iterable $iterable): void
    {
        self::assertSame($expected, Arr::filterNulls($iterable));
    }

    public static function filterNullsDataProvider(): iterable
    {
        yield [[], []];
        yield [[false, 1, true, 0, 9.2], new \ArrayIterator([false, 1, true, 0, null, 9.2])];
        yield [[], [null, null]];
        yield [[false], [null, false]];
        yield [['null', ''], ['null', '']];
    }

    #[DataProvider('mapDataProvider')]
    public function testMap(iterable $input, \Closure $function, array $expectedOutput): void
    {
        /** @phpstan-ignore-next-line */
        self::assertSame($expectedOutput, Arr::map($input, $function));
    }

    public static function mapDataProvider(): iterable
    {
        yield [
            [1, 2, 3],
            static function (int $v): int {
                return $v;
            },
            [1, 2, 3],
        ];

        yield [
            [1, 2, 3],
            static function (int $v): int {
                return $v * 2;
            },
            [2, 4, 6],
        ];

        yield [
            [1, 2, 3],
            static function (int $v): string {
                return (string)$v;
            },
            ['1', '2', '3'],
        ];

        yield [
            [10 => 1, 2, 3],
            static function (int $v): string {
                return (string)$v;
            },
            ['1', '2', '3'],
        ];

        yield [
            [],
            static function (int $v): string {
                return (string)$v;
            },
            [],
        ];

        yield [
            new \ArrayIterator([1, 2, 3]),
            static function (int $v): int {
                return $v;
            },
            [1, 2, 3],
        ];

        yield [
            new \ArrayIterator([1, 2, 3]),
            static function (int $v): int {
                return $v * 2;
            },
            [2, 4, 6],
        ];

        yield [
            new \ArrayIterator([1, 2, 3]),
            static function (int $v): string {
                return (string)$v;
            },
            ['1', '2', '3'],
        ];

        yield [
            new \ArrayIterator([]),
            static function (int $v): string {
                return (string)$v;
            },
            [],
        ];
    }
}
