<?php

declare(strict_types=1);

namespace HomeCalculator\Tests;

use HomeCalculator\Provider\AOSAHProvider;
use PHPUnit\Framework\TestCase;

final class TestAOSAHProvider extends TestCase
{
    public function testParsedContent(): void
    {
        $provider = new AOSAHProvider('https://xn--80aa5bmv.xn--p1ai/about/tariffs/');
        self::assertEquals('АО «САХ»', $provider->getOrganizationName());
        $service1 = $provider->getServiceById('1');
        self::assertEquals('Обращение с ТКО', $service1->getName());
        self::assertEquals('91.52', $service1->getTax());
    }
}