<?php

declare(strict_types=1);

namespace SoftWaxTests\Utils;

use PHPUnit\Framework\TestCase;
use SoftWax\Utils\Assert;

class AssertTest extends TestCase
{
    public function testProvidesTraceInExceptionMessage(): void
    {
        try {
            Assert::true(false);
        } catch (\InvalidArgumentException $e) {
            self::assertSame($e::class, \InvalidArgumentException::class);
            self::assertStringContainsString(\sprintf('Trace: %s:15', __FILE__), $e->getMessage());
        }
    }
}
