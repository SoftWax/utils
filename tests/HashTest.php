<?php

declare(strict_types=1);

namespace SoftWaxTests\Utils;

use PHPUnit\Framework\TestCase;
use SoftWax\Utils\Hash;

class HashTest extends TestCase
{
    public function testInvalidAlgorithm(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Hashing algorithm "test" is not supported');

        new Hash('test');
    }

    public function testXxh3(): void
    {
        $v1 = Hash::xxh3('value');
        $v2 = Hash::xxh3('Value');
        self::assertSame(16, \mb_strlen($v1));
        self::assertSame(16, \mb_strlen($v2));
        self::assertSame($v1, Hash::xxh3('value'));
        self::assertNotSame($v1, $v2);
    }

    public function testXxh128(): void
    {
        $v1 = Hash::xxh128('value');
        $v2 = Hash::xxh128('Value');
        self::assertSame(32, \mb_strlen($v1));
        self::assertSame(32, \mb_strlen($v2));
        self::assertSame($v1, Hash::xxh128('value'));
        self::assertNotSame($v1, $v2);
    }
}
