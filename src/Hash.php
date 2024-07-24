<?php

declare(strict_types=1);

namespace SoftWax\Utils;

final readonly class Hash
{
    public function __construct(
        private string $algorithm = 'xxh128',
        private bool $binary = false,
        private array $options = [],
    ) {
        Assert::inArray(
            $this->algorithm,
            \hash_algos(),
            \sprintf('Hashing algorithm "%s" is not supported', $algorithm),
        );
    }

    public static function xxh3(string $string): string
    {
        return (new self('xxh3'))->hash($string);
    }

    public static function xxh128(string $string): string
    {
        return (new self('xxh128'))->hash($string);
    }

    public function hash(string $value): string
    {
        return \hash($this->algorithm, $value, $this->binary, $this->options);
    }
}
