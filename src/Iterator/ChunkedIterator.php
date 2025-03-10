<?php

declare(strict_types=1);

namespace SoftWax\Utils\Iterator;

use SoftWax\Utils\Assert;

/**
 * @template T
 * @implements \IteratorAggregate<non-empty-list<T>>
 */
final readonly class ChunkedIterator implements \IteratorAggregate
{
    /**
     * @param iterable<T> $iterator
     * @param positive-int $chunkSize
     */
    public function __construct(
        private iterable $iterator,
        private int $chunkSize,
    ) {
        Assert::greaterThan($chunkSize, 0, \sprintf('The chunk size must be greater than zero, %d given', $chunkSize));
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): \Traversable
    {
        $chunk = [];
        foreach ($this->iterator as $v) {
            $chunk[] = $v;

            if (\count($chunk) === $this->chunkSize) {
                yield $chunk;

                $chunk = [];
            }
        }

        if ($chunk !== []) {
            yield $chunk;
        }
    }
}
