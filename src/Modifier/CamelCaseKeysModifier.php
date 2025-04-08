<?php

declare(strict_types=1);

namespace SoftWax\Utils\Modifier;

/**
 * @implements \IteratorAggregate<mixed>
 */
final readonly class CamelCaseKeysModifier implements \IteratorAggregate
{
    private array $source;

    public function __construct(iterable $source)
    {
        $this->source = $this->replace($source);
    }

    public static function invoke(iterable $source): array
    {
        return (new CamelCaseKeysModifier($source))->source;
    }

    /**
     * @param iterable<mixed> $source
     * @return array<mixed>
     */
    private function replace(iterable $source): array
    {
        $result = [];

        foreach ($source as $key => $value) {
            if (\is_iterable($value)) {
                $value = $this->replace($value);
            }

            if (!\is_string($key)) {
                $result[$key] = $value;

                continue;
            }

            $camelCaseKey = $this->camelCaseKeys($key);

            if (isset($result[$camelCaseKey])) {
                continue;
            }

            $result[$camelCaseKey] = $value;
        }

        return $result;
    }

    private function camelCaseKeys(string $key): string
    {
        return \mb_lcfirst(\str_replace([' ', '_', '-'], '', \ucwords($key, ' _-')));
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): \Traversable
    {
        yield from $this->source;
    }
}
