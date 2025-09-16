<?php

declare(strict_types=1);

namespace HomeCalculator\Tests;

use HomeCalculator\Driver\Service;
use HomeCalculator\Provider\AOSAHProvider;
use PHPUnit\Framework\TestCase;

final class TestAOSAHProvider extends TestCase
{
    public function testParsedContent(): void
    {
        $provider = new AOSAHProvider('https://xn--80aa5bmv.xn--p1ai/about/tariffs/');
        $info = $provider->loadCard();
        self::assertEquals('АО "САХ"', $info['organizationName']);

        /** @var Service $service */
        $service = $info['services'][$provider->generateServiceKey('1')];
        self::assertEquals('Обращение с ТКО', $service->getName());
        self::assertEquals('91.52', $service->getTax());
        self::assertEquals('с одного человека, прописанного в квартире', $service->getUnit());
    }
}