<?php

declare(strict_types=1);

namespace SoftWax\Utils;

final readonly class Json
{
    /**
     * @throws \JsonException
     */
    public static function encode(mixed $value): string
    {
        return \json_encode(
            $value,
            \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES | \JSON_PRESERVE_ZERO_FRACTION | \JSON_THROW_ON_ERROR,
        );
    }

    /**
     * @throws \JsonException
     */
    public static function decode(string $json, bool $assoc = false): mixed
    {
        return \json_decode(
            $json,
            $assoc,
            512,
            \JSON_BIGINT_AS_STRING | \JSON_THROW_ON_ERROR,
        );
    }
}
