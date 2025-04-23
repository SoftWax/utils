<?php

declare(strict_types=1);

namespace SoftWaxTests\Utils\Datastructure;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SoftWax\Utils\Datastructure\Queue;

class QueueTest extends TestCase
{
    public function testDefaultBehaviour(): void
    {
        $queue1 = new Queue();
        $queue1->enqueue('a');
        $queue1->enqueue('b');
        $queue1->enqueue('c');
        $queue1->enqueue('d');
        self::assertSame(['a', 'b'], $queue1->dequeueFew(2));

        $queue2 = new Queue();
        $queue2->enqueueAll($queue1->dequeueAll());
        self::assertSame(['c', 'd'], $queue2->dequeueFew(2));
    }

    #[DataProvider('dequeueAllDataProvider')]
    public function testDequeueAll(
        array $input,
        array $expectedOutput,
    ): void {
        $queue = new Queue($input);

        self::assertCount(\count($input), $queue);
        self::assertSame($expectedOutput, $queue->dequeueAll());
        self::assertTrue($queue->isEmpty());
        self::assertSame(0, $queue->count());
    }

    public static function dequeueAllDataProvider(): iterable
    {
        yield [[], []];

        yield [
            ['4c63c8cf-35b9-4e91-9f49-bd3a3222a40e', 'e5dfafee-f461-43a5-a4c4-048f6f993dd2'],
            ['4c63c8cf-35b9-4e91-9f49-bd3a3222a40e', 'e5dfafee-f461-43a5-a4c4-048f6f993dd2'],
        ];
    }

    /**
     * @param int<1, max> $amount
     */
    #[DataProvider('dequeueManyDataProvider')]
    public function testDequeueMany(
        array $input,
        int $amount,
        array $expectedOutput,
    ): void {
        $queue = new Queue($input);

        self::assertCount(\count($input), $queue);
        $output = $queue->dequeueFew($amount);
        self::assertSame($expectedOutput, $output);
        self::assertSame(\count($input) - \count($output), $queue->count());
    }

    public static function dequeueManyDataProvider(): iterable
    {
        yield [[], 1, []];

        yield [[], 100, []];

        yield [
            ['948be930-aa3e-48e3-86f0-c3a49dc3c8d2', '2730a3a6-c7dc-4ad5-be53-0bfce93758c5'],
            1,
            ['948be930-aa3e-48e3-86f0-c3a49dc3c8d2'],
        ];

        yield [
            ['948be930-aa3e-48e3-86f0-c3a49dc3c8d2', '2730a3a6-c7dc-4ad5-be53-0bfce93758c5'],
            2,
            ['948be930-aa3e-48e3-86f0-c3a49dc3c8d2', '2730a3a6-c7dc-4ad5-be53-0bfce93758c5'],
        ];

        yield [
            ['948be930-aa3e-48e3-86f0-c3a49dc3c8d2', '2730a3a6-c7dc-4ad5-be53-0bfce93758c5'],
            10,
            ['948be930-aa3e-48e3-86f0-c3a49dc3c8d2', '2730a3a6-c7dc-4ad5-be53-0bfce93758c5'],
        ];

        yield [
            [
                '948be930-aa3e-48e3-86f0-c3a49dc3c8d2',
                '2730a3a6-c7dc-4ad5-be53-0bfce93758c5',
                'c5bde30f-c5ee-43ed-a5f0-5fc41e4abf48',
            ],
            3,
            [
                '948be930-aa3e-48e3-86f0-c3a49dc3c8d2',
                '2730a3a6-c7dc-4ad5-be53-0bfce93758c5',
                'c5bde30f-c5ee-43ed-a5f0-5fc41e4abf48',
            ],
        ];
    }
}
