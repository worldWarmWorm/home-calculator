<?php

declare(strict_types=1);

namespace HomeCalculator\Delivery;

use Dotenv\Dotenv;

abstract class Delivery implements DeliveryInterface
{
    private const string DOT_ENV_PATH = __DIR__ . '/../../';

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(self::DOT_ENV_PATH);
        $dotenv->load();
    }
}