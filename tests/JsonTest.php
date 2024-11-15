<?php

declare(strict_types=1);

namespace SoftWaxTests\Utils;

use PHPUnit\Framework\TestCase;
use SoftWax\Utils\Json;

class JsonTest extends TestCase
{
    public function testSuccessfullyEncodesValueToJson(): void
    {
        self::assertSame(
            '{"test":123,"o":["value"],"float":12.0}',
            Json::encode(['test' => 123, 'o' => ['value'], 'float' => 12.0]),
        );
    }

    public function testSuccessfullyEncodesValueToPrettyJson(): void
    {
        self::assertSame(
            <<<'JSON'
{
    "test": 123,
    "o": [
        "value"
    ],
    "float": 12.0
}
JSON,
            Json::encode(['test' => 123, 'o' => ['value'], 'float' => 12.0], true),
        );
    }

    public function testThrowsExceptionOnFailedJsonEncoding(): void
    {
        $this->expectException(\JsonException::class);

        Json::encode([\fopen(__DIR__ . '/JsonTest.php', 'rb')]);
    }

    public function testSuccessfullyDecodesJsonToValue(): void
    {
        self::assertSame(
            ['test' => 123, 'o' => ['value'], 'float' => 12.0],
            Json::decode('{"test":123,"o":["value"],"float":12.0}', true),
        );

        $objectOutput = Json::decode('{"test":123,"o":["value"],"float":12.12}');
        self::assertInstanceOf(\stdClass::class, $objectOutput);
        self::assertSame(
            [
                123,
                ['value'],
                12.12,
            ],
            [
                $objectOutput->test,
                $objectOutput->o,
                $objectOutput->float,
            ],
        );
    }

    public function testThrowsExceptionOnFailedJsonDecoding(): void
    {
        $this->expectException(\JsonException::class);

        Json::decode('invalid{json}');
    }
}
