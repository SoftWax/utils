<?php

declare(strict_types=1);

namespace SoftWax\Utils\Iterator;

/**
 * @template T
 * @implements \IteratorAggregate<T>
 */
final readonly class CallbackFilterIterator implements \IteratorAggregate
{
    /**
     * @param iterable<T> $iterator
     * @param \Closure(T): bool $filter
     */
    public function __construct(
        private iterable $iterator,
        private \Closure $filter,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): \Traversable
    {
        foreach ($this->iterator as $v) {
            if (($this->filter)($v)) {
                yield $v;
            }
        }
    }
}
