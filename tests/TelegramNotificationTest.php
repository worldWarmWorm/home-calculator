<?php

declare(strict_types=1);

namespace HomeCalculator\Tests;

use HomeCalculator\Delivery\LevelEnum;
use HomeCalculator\Delivery\Telegram\Notification;
use PHPUnit\Framework\TestCase;

final class TelegramNotificationTest extends TestCase
{
    public function testSendingAlert(): void
    {
        $alert = new Notification('testSendingAlert', LevelEnum::NOTICE->value);
        $json = (array)json_decode($alert->send());

        self::assertArrayHasKey('ok', $json);
        self::assertTrue($json['ok']);
        self::assertArrayHasKey('result', $json);
        $result = (array)$json['result'];
        self::assertArrayHasKey('text', $result);
        self::assertEquals('[NOTICE] - testSendingAlert', $result['text']);
    }
}