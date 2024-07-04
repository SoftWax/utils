<?php

declare(strict_types=1);

namespace SoftWax\Utils;

final readonly class Arr
{
    /**
     * A performant way to check key existence in array.
     */
    public static function keyExists(array $array, string|int $key): bool
    {
        return isset($array[$key]) || \array_key_exists($key, $array);
    }

    /**
     * Returns a list containing only the values for which the given callback returns `true`.
     * The default callback is casting the value to boolean.
     *
     * @template T
     * @param iterable<T> $iterable
     * @param (\Closure(T): bool)|null $callback
     * @return list<T>
     */
    public static function filter(iterable $iterable, ?\Closure $callback = null): array
    {
        /** @var \Closure(T): bool $callback */
        $callback = $callback ?? static fn (mixed $value): bool => (bool)$value;

        if (\is_array($iterable)) {
            return \array_values(
                \array_filter(
                    $iterable,
                    /**
                     * @param T $t
                     */
                    static function (mixed $t) use ($callback): bool {
                        return $callback($t);
                    },
                ),
            );
        }

        $result = [];
        foreach ($iterable as $v) {
            if ($callback($v)) {
                $result[] = $v;
            }
        }

        return $result;
    }

    /**
     * Filter out null values from the given iterable.
     *
     * @template T
     * @param iterable<T|null> $iterable
     * @return list<T>
     */
    public static function filterNulls(iterable $iterable): array
    {
        /** @phpstan-ignore-next-line */
        return self::filter(
            $iterable,
            static function (mixed $value): bool {
                return $value !== null;
            },
        );
    }
}
