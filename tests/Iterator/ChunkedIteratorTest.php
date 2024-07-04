<?php

declare(strict_types=1);

namespace SoftWaxTests\Utils\Iterator;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SoftWax\Utils\Iterator\ChunkedIterator;

class ChunkedIteratorTest extends TestCase
{
    /**
     * @param int<1, max> $chunkSize
     */
    #[DataProvider('chunksProvider')]
    public function testChunksIterator(array $input, int $chunkSize, array $expectedOutput): void
    {
        self::assertSame(
            $expectedOutput,
            \iterator_to_array(new ChunkedIterator(new \ArrayIterator($input), $chunkSize), false),
        );
    }

    public static function chunksProvider(): iterable
    {
        yield [
            [],
            100,
            [],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            2,
            [
                [1, 2],
                [3, 4],
                [5, 6],
            ],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            10,
            [
                [1, 2, 3, 4, 5, 6],
            ],
        ];
    }

    #[DataProvider('invalidChunkSizeProvider')]
    public function testThrowsExceptionOnInvalidChunkSize(int $chunkSize): void
    {
        $this->expectException(\InvalidArgumentException::class);
        /** @phpstan-ignore-next-line */
        new ChunkedIterator(new \ArrayIterator(['a', 'b', 'c']), $chunkSize);
    }

    public static function invalidChunkSizeProvider(): iterable
    {
        yield [0];
        yield [-1];
        yield [-10];
    }

    public function testAllowArray(): void
    {
        self::assertSame([[1, 2, 3], [4, 5, 6]], \iterator_to_array(new ChunkedIterator([1, 2, 3, 4, 5, 6], 3), false));
    }

    public function testAllowRewind(): void
    {
        $iterator = new ChunkedIterator(new \ArrayIterator([1, 2, 3, 4, 5, 6]), 3);

        self::assertSame([[1, 2, 3], [4, 5, 6]], \iterator_to_array($iterator, false));
        self::assertSame([[1, 2, 3], [4, 5, 6]], \iterator_to_array($iterator, false));
        self::assertSame([[1, 2, 3], [4, 5, 6]], \iterator_to_array($iterator, false));
    }
}
