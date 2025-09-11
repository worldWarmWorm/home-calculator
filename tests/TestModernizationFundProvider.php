<?php

declare(strict_types=1);

namespace HomeCalculator\Tests;

use HomeCalculator\Provider\ModernizationFundProvider;
use PHPUnit\Framework\TestCase;

class TestModernizationFundProvider extends TestCase
{
    public function testParsedContent(): void
    {
        $provider = new ModernizationFundProvider('https://xn--80aa5bmv.xn--p1ai/about/tariffs/');
        $name = $provider->getOrganizationName();
        $tax = $provider->getTax();
        $measure = $provider->getCurrency();

        self::assertEquals('АО «САХ»', $name);
        self::assertEquals('91.52', $tax);
        self::assertEquals('руб', $measure);
    }
}