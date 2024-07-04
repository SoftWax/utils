<?php

declare(strict_types=1);

namespace SoftWaxTests\Utils\Iterator;

use PHPUnit\Framework\TestCase;
use SoftWax\Utils\Iterator\CallbackFilterIterator;

class CallbackFilterIteratorTest extends TestCase
{
    public function testEmptyInput(): void
    {
        $mapIterator = new CallbackFilterIterator(
            new \ArrayIterator([]),
            static function (array $data): bool {
                return true;
            },
        );

        self::assertEmpty(\iterator_to_array($mapIterator, false));
    }

    public function testSingleItem(): void
    {
        $mapIterator = new CallbackFilterIterator(
            new \ArrayIterator([['my' => 'item'], ['my' => 'none']]),
            static function (array $data): bool {
                return $data['my'] === 'none';
            },
        );

        self::assertSame([['my' => 'none']], \iterator_to_array($mapIterator, false));
    }

    public function testMultipleItems(): void
    {
        $mapIterator = new CallbackFilterIterator(
            new \ArrayIterator([['my' => new \stdClass()], ['my' => 123], ['my' => false]]),
            static function (array $data): bool {
                return \is_bool($data['my']);
            },
        );

        self::assertEquals([['my' => false]], \iterator_to_array($mapIterator, false));
    }

    public function testAllowArray(): void
    {
        $mapIterator = new CallbackFilterIterator(
            [['my' => 'item'], ['my' => 'none']],
            static function (array $data): bool {
                return $data['my'] === 'item';
            },
        );

        self::assertSame([['my' => 'item']], \iterator_to_array($mapIterator, false));
        self::assertSame([['my' => 'item']], \iterator_to_array($mapIterator, false));
        self::assertSame([['my' => 'item']], \iterator_to_array($mapIterator, false));
    }

    public function testAllowRewind(): void
    {
        $mapIterator = new CallbackFilterIterator(
            new \ArrayIterator([['my' => 'item'], ['my' => 'none']]),
            static function (array $data): bool {
                return $data['my'] === 'none';
            },
        );

        self::assertSame([['my' => 'none']], \iterator_to_array($mapIterator, false));
        self::assertSame([['my' => 'none']], \iterator_to_array($mapIterator, false));
        self::assertSame([['my' => 'none']], \iterator_to_array($mapIterator, false));
    }
}
