<?php

declare(strict_types=1);

namespace SoftWaxTests\Utils\Modifier;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SoftWax\Utils\Modifier\CamelCaseKeysModifier;

class CamelCaseKeysModifierTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testModifier(
        iterable $source,
        array $expectedOutput,
    ): void {
        self::assertSame($expectedOutput, CamelCaseKeysModifier::invoke($source));
        self::assertSame($expectedOutput, \iterator_to_array(new CamelCaseKeysModifier($source), true));
    }

    public static function dataProvider(): iterable
    {
        yield [
            ['some key' => 'foo'],
            ['someKey' => 'foo'],
        ];

        yield [
            ['some-key' => 'foo'],
            ['someKey' => 'foo'],
        ];

        yield [
            ['some_key' => 'foo'],
            ['someKey' => 'foo'],
        ];

        yield [
            ['someKey' => 'foo'],
            ['someKey' => 'foo'],
        ];

        yield [
            ['somekey' => 'foo'],
            ['somekey' => 'foo'],
        ];

        yield [
            ['level-one' => ['level-two' => 'foo']],
            ['levelOne' => ['levelTwo' => 'foo']],
        ];

        yield [
            [
                ['level-one' => 'foo'],
                ['level-one' => 'bar'],
            ],
            [
                ['levelOne' => 'foo'],
                ['levelOne' => 'bar'],
            ],
        ];

        yield [
            [
                'level-one' => [
                    ['level-two' => 'bar'],
                    ['level-two' => 'buz'],
                ],
            ],
            [
                'levelOne' => [
                    ['levelTwo' => 'bar'],
                    ['levelTwo' => 'buz'],
                ],
            ],
        ];

        yield [
            [
                'level-one' => [
                    'level-two-a' => ['level-three' => 'bar'],
                    'level-two-b' => ['level-three' => 'buz'],
                ],
            ],
            [
                'levelOne' => [
                    'levelTwoA' => ['levelThree' => 'bar'],
                    'levelTwoB' => ['levelThree' => 'buz'],
                ],
            ],
        ];

        yield [
            [
                'level-one' => [
                    ['level-two' => 'bar'],
                    ['level-two' => 'buz'],
                ],
            ],
            [
                'levelOne' => [
                    ['levelTwo' => 'bar'],
                    ['levelTwo' => 'buz'],
                ],
            ],
        ];
    }
}
