<?php

declare(strict_types=1);

namespace SoftWax\Utils\Iterator;

/**
 * @template T
 * @template U
 * @implements \IteratorAggregate<U>
 */
final readonly class MapIterator implements \IteratorAggregate
{
    /**
     * @param iterable<T> $iterator
     * @param \Closure(T): U $mapper
     */
    public function __construct(
        private iterable $iterator,
        private \Closure $mapper,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): \Traversable
    {
        foreach ($this->iterator as $v) {
            yield ($this->mapper)($v);
        }
    }
}
