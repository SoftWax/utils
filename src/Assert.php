<?php

declare(strict_types=1);

namespace SoftWax\Utils;

use Webmozart\Assert\Assert as BaseAssert;

final class Assert extends BaseAssert
{
    /**
     * {@inheritdoc}
     */
    protected static function reportInvalidArgument($message): never
    {
        $trace = \debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        if (isset($trace[1]['file'], $trace[1]['line'])) {
            $message .= \sprintf('. Trace: %s:%s', $trace[1]['file'], $trace[1]['line']);
        }

        throw new \InvalidArgumentException($message);
    }
}
