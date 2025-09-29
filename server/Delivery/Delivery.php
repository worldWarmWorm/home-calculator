<?php

declare(strict_types=1);

namespace HomeCalculator\Delivery;

use Dotenv\Dotenv;

abstract class Delivery implements DeliveryInterface
{
    private const array LEVEL_PREFIXES = [
        LevelEnum::CRITICAL->value => "[CRITICAL]",
        LevelEnum::NOTICE->value => "[NOTICE]",
    ];

    private const string DOT_ENV_PATH = __DIR__ . '/../../';

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(self::DOT_ENV_PATH);
        $dotenv->load();
    }

    protected function getMessage(string $message, string $level): string
    {
        $prefix = self::LEVEL_PREFIXES[$level] ?? null;

        if (null === $prefix) {
            throw new DeliveryException("Invalid level $level");
        }

        return "$prefix - $message";
    }
}