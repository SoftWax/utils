<?php

declare(strict_types=1);

namespace SoftWaxTests\Utils\Iterator;

use PHPUnit\Framework\TestCase;
use SoftWax\Utils\Iterator\MapIterator;

class MapIteratorTest extends TestCase
{
    public function testEmptyInput(): void
    {
        $mapIterator = new MapIterator(
            new \ArrayIterator([]),
            static function (array $data): bool {
                return true;
            },
        );

        self::assertEmpty(\iterator_to_array($mapIterator, false));
    }

    public function testSingleItem(): void
    {
        $mapIterator = new MapIterator(
            new \ArrayIterator([['my' => 'item']]),
            static function (array $data): string {
                return $data['my'];
            },
        );

        self::assertSame(['item'], \iterator_to_array($mapIterator, false));
    }

    public function testMultipleItems(): void
    {
        $mapIterator = new MapIterator(
            new \ArrayIterator([['my' => new \stdClass()], ['my' => 123], ['my' => false]]),
            static function (array $data): mixed {
                return $data['my'];
            },
        );

        self::assertEquals([new \stdClass(), 123, false], \iterator_to_array($mapIterator, false));
    }

    public function testAllowArray(): void
    {
        $mapIterator = new MapIterator(
            [['my' => 'item'], ['my' => 'object']],
            static function (array $data): mixed {
                return $data['my'];
            },
        );
        self::assertSame(['item', 'object'], \iterator_to_array($mapIterator, false));
    }

    public function testAllowRewind(): void
    {
        $mapIterator = new MapIterator(
            new \ArrayIterator([['my' => 'item'], ['my' => 'object']]),
            static function (array $data): mixed {
                return $data['my'];
            },
        );
        self::assertSame(['item', 'object'], \iterator_to_array($mapIterator, false));
        self::assertSame(['item', 'object'], \iterator_to_array($mapIterator, false));
        self::assertSame(['item', 'object'], \iterator_to_array($mapIterator, false));
    }
}
