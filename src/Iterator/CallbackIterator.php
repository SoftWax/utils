<?php

declare(strict_types=1);

namespace SoftWax\Utils\Iterator;

/**
 * @template T
 * @implements \IteratorAggregate<T>
 */
final readonly class CallbackIterator implements \IteratorAggregate
{
    /**
     * @param \Closure(): iterable<T> $callback
     */
    public function __construct(
        private \Closure $callback,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): \Traversable
    {
        yield from ($this->callback)();
    }
}
