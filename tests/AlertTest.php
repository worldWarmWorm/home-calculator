<?php

declare(strict_types=1);

namespace HomeCalculator\Tests;

use HomeCalculator\Delivery\Alert;
use PHPUnit\Framework\TestCase;

final class AlertTest extends TestCase
{
    public function testSendingAlert(): void
    {
        $alert = new Alert('testSendingAlert');
        $json = (array)json_decode($alert->send());

        self::assertArrayHasKey('ok', $json);
        self::assertTrue($json['ok']);
        self::assertArrayHasKey('result', $json);
        $result = (array)$json['result'];
        self::assertArrayHasKey('text', $result);
        self::assertEquals('testSendingAlert', $result['text']);
    }
}