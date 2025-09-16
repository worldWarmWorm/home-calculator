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
        $card = $provider->loadCard();
        self::assertEquals('АО "САХ"', $card['organizationName']);
        /** @var Service $service1 */
        $service1 = $card['services'][0];
        self::assertEquals('Обращение с ТКО', $service1->getName());
        self::assertEquals('91.52', $service1->getTax());
        self::assertEquals('с одного человека, прописанного в квартире', $service1->getUnit());
    }
}