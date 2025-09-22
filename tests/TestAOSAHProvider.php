<?php

declare(strict_types=1);

namespace HomeCalculator\Tests;

use HomeCalculator\Provider\AOSAHProvider;
use PHPUnit\Framework\TestCase;

final class TestAOSAHProvider extends TestCase
{
    public function testProviderData(): AOSAHProvider
    {
        $provider = new AOSAHProvider('https://xn--80aa5bmv.xn--p1ai/about/tariffs/');
        self::assertEquals('АО "САХ"', $provider->getOrganizationName());
        $service = $provider->getServiceByKey($provider->generateServiceKey('1'));
        self::assertEquals('Обращение с ТКО', $service->getName());
        self::assertEquals('91.52', $service->getTax());
        self::assertEquals('с одного человека, прописанного в квартире', $service->getUnit());

        return $provider;
    }

    /**
     * @depends testProviderData
     */
    public function testIsActualServicesTaxes(AOSAHProvider $provider): void
    {
        $taxes = $provider->parseTaxesByServiceKeys([$provider->generateServiceKey('1')]);

        foreach ($taxes as $serviceKey => $tax) {
            self::assertEquals($provider->getServiceByKey($serviceKey)->getTax(), $tax);
        }
    }
}