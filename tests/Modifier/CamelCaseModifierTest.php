<?php

declare(strict_types=1);

namespace SoftWaxTests\Utils\Modifier;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SoftWax\Utils\Modifier\CamelCaseModifier;

class CamelCaseModifierTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testModifier(
        iterable $source,
        array $expectedOutput,
    ): void {
        self::assertSame($expectedOutput, CamelCaseModifier::invoke($source));
        self::assertSame($expectedOutput, \iterator_to_array(new CamelCaseModifier($source), true));
    }

    public static function dataProvider(): iterable
    {
        yield [
            ['some key' => 'contact organiser status', true, 1],
            ['some key' => 'contactOrganiserStatus', true, 1],
        ];

        yield [
            ['contact_organiser_status'],
            ['contactOrganiserStatus'],
        ];

        yield [
            ['contact-organiser-status'],
            ['contactOrganiserStatus'],
        ];

        yield [
            [['contact-organiser-status']],
            [['contactOrganiserStatus']],
        ];
    }
}
