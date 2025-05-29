<?php

declare(strict_types=1);

namespace SoftWax\Utils;

final readonly class Type
{
    /**
     * Casts string|\Stringable value to non-empty string if possible, otherwise - returns null.
     *
     * @return non-empty-string|null
     */
    public static function coerceNonEmptyStringOrNull(mixed $value): ?string
    {
        $value = match (true) {
            \is_string($value) => \mb_trim($value),
            $value instanceof \Stringable => \mb_trim($value->__toString()),
            default => $value,
        };

        return $value !== '' && \is_string($value) ? $value : null;
    }

    /**
     * @return non-empty-array|null
     */
    public static function coerceNonEmptyArrayOrNull(mixed $value): ?array
    {
        return match (true) {
            \is_array($value) && $value !== [] => $value,
            default => null,
        };
    }
}
