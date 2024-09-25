<?php

declare(strict_types=1);

namespace SoftWax\Utils\Datastructure;

/**
 * @template T
 * @extends \SplQueue<T>
 */
class Queue extends \SplQueue
{
    /**
     * @param T[] $items
     */
    public function __construct(array $items = [])
    {
        $this->enqueueAll($items);
    }

    /**
     * @param T[] $items
     */
    public function enqueueAll(array $items): void
    {
        foreach ($items as $item) {
            $this->enqueue($item);
        }
    }

    /**
     * @return T[]
     */
    public function dequeueAll(): array
    {
        $items = [];
        while (!$this->isEmpty()) {
            $items[] = $this->dequeue();
        }

        return $items;
    }

    /**
     * @param int<1, max> $amount
     * @return T[]
     */
    public function dequeueFew(int $amount): array
    {
        $items = [];
        while ($amount > 0 && !$this->isEmpty()) {
            $items[] = $this->dequeue();
            $amount--;
        }

        return $items;
    }
}
