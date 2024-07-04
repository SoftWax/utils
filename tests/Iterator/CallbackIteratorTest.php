<?php

declare(strict_types=1);

namespace SoftWaxTests\Utils\Iterator;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SoftWax\Utils\Iterator\CallbackIterator;

class CallbackIteratorTest extends TestCase
{
    #[DataProvider('callbackDataProvider')]
    public function testCallback(\Closure $callable, array $expectedOutput): void
    {
        self::assertSame($expectedOutput, \iterator_to_array(new CallbackIterator($callable), false));
    }

    public static function callbackDataProvider(): iterable
    {
        yield [
            static function (): array {
                return [];
            },
            [],
        ];

        yield [
            static function (): array {
                return [['test'], 3, [true]];
            },
            [['test'], 3, [true]],
        ];

        yield [
            static function (): \ArrayIterator {
                return new \ArrayIterator([['test'], 3, [true]]);
            },
            [['test'], 3, [true]],
        ];

        yield [
            static function (): \Generator {
                yield 1;
                yield '2';
                yield from [55, 66];
                yield false;
            },
            [1, '2', 55, 66, false],
        ];
    }

    public function testAllowRewind(): void
    {
        $iterator = new CallbackIterator(
            static function (): \ArrayIterator {
                return new \ArrayIterator([['test'], 3, [true]]);
            },
        );

        self::assertSame([['test'], 3, [true]], \iterator_to_array($iterator, false));
        self::assertSame([['test'], 3, [true]], \iterator_to_array($iterator, false));
        self::assertSame([['test'], 3, [true]], \iterator_to_array($iterator, false));
    }
}
