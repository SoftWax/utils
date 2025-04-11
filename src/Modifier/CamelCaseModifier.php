<?php

declare(strict_types=1);

namespace SoftWax\Utils\Modifier;

/**
 * @implements \IteratorAggregate<mixed>
 */
final readonly class CamelCaseModifier implements \IteratorAggregate
{
    private array $source;

    public function __construct(iterable $source)
    {
        $this->source = $this->replace($source);
    }

    public static function invoke(iterable $source): array
    {
        return (new CamelCaseModifier($source))->source;
    }

    /**
     * @param iterable<mixed> $source
     * @return array<mixed>
     */
    private function replace(iterable $source): array
    {
        $result = [];

        foreach ($source as $key => $value) {
            $result[$key] = match (true) {
                \is_iterable($value) => $this->replace($value),
                \is_string($value) => $this->camelCase($value),
                default => $value,
            };
        }

        return $result;
    }

    private function camelCase(string $value): string
    {
        return \mb_lcfirst(\str_replace([' ', '_', '-'], '', \ucwords($value, ' _-')));
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): \Traversable
    {
        yield from $this->source;
    }
}
