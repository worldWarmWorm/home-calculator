<?php

declare(strict_types=1);

namespace HomeCalculator\Tests;

use HomeCalculator\Driver\Service;
use HomeCalculator\Provider\AOSAHProvider;
use PHPUnit\Framework\TestCase;

final class TestAOSAHProvider extends TestCase
{
    public function testProviderData(): AOSAHProvider
    {
        $provider = new AOSAHProvider('https://xn--80aa5bmv.xn--p1ai/about/tariffs/');
        $card = $provider->loadCard();
        self::assertEquals('АО "САХ"', $card['organizationName']);
        /** @var Service $service1 */
        $service1 = $card['services'][0];
        self::assertEquals('Обращение с ТКО', $service1->getName());
        self::assertEquals('91.52', $service1->getTax());
        self::assertEquals('с одного человека, прописанного в квартире', $service1->getUnit());

        return $provider;
    }

    /**
     * @depends testProviderData
     */
    public function testServicesTaxesIsActual(AOSAHProvider $provider): void
    {
        $taxes = $provider->parseTaxesByServiceKeys([$provider->generateServiceKey('1')]);

        foreach ($taxes as $serviceKey => $tax) {
            self::assertEquals($provider->getServiceByKey($serviceKey)->getTax(), $tax);
        }
    }
}