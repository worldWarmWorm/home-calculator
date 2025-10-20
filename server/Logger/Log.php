<?php

declare(strict_types=1);

namespace HomeCalculator\Logger;

use DateTimeZone;
use HomeCalculator\Core\TimezoneEnum;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

final class Log
{
    private const string PATH = __DIR__ . '/app.log';

    private static null|Logger $logger;

    private function __construct()
    {
    }

    public static function create(
        string $message,
        Level $level,
        ?DateTimeZone $timezone = null
    ): void
    {
        self::$logger ??= new Logger(
            'HomeCalculator',
            [new StreamHandler(self::PATH, $level)],
            timezone: $timezone ?? new DateTimeZone(TimezoneEnum::NOVOSIBIRSK->value)
        );
        self::$logger->log($level, $message);
    }
}