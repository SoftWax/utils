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
            $value instanceof \Stringable => \trim($value->__toString()),
            \is_string($value) => \trim($value),
            default => $value,
        };

        return $value !== '' && \is_string($value) ? $value : null;
    }
}
