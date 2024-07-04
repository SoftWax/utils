<?php

declare(strict_types=1);

namespace SoftWax\Utils\Test;

use PHPUnit\Framework\Constraint\Callback;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\IsIdentical;

// @see: https://stackoverflow.com/questions/75389000/replace-phpunit-method-withconsecutive
// @see: https://stackoverflow.com/questions/21861825/quick-way-to-find-the-largest-array-in-a-multidimensional-array
trait ConsecutiveParamsTrait
{
    public function consecutiveParams(array ...$args): array
    {
        $callbacks = [];

        $count = 0;
        foreach ($args as $arg) {
            $argCount = \count($arg);
            if ($count < $argCount) {
                $count = $argCount;
            }
        }

        for ($index = 0; $index < $count; $index++) {
            $returns = [];

            foreach ($args as $arg) {
                if (!\array_is_list($arg)) {
                    throw new \InvalidArgumentException('Every array must be a list');
                }

                if (!\array_key_exists($index, $arg)) {
                    throw new \InvalidArgumentException(\sprintf('Every array must contain %d parameters', $count));
                }

                $returns[] = $arg[$index];
            }

            $callbacks[] = new Callback(
                new class ($returns) {
                    public function __construct(private array $returns)
                    {
                    }

                    public function __invoke(mixed $actual): bool
                    {
                        if (\count($this->returns) === 0) {
                            return true;
                        }

                        $next = \array_shift($this->returns);
                        if ($next instanceof Constraint) {
                            $next->evaluate($actual);

                            return true;
                        }

                        (new IsIdentical($next))->evaluate($actual);

                        return true;
                    }
                },
            );
        }

        return $callbacks;
    }
}
