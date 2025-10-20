<?php

declare(strict_types=1);

namespace HomeCalculator\Tests;

use HomeCalculator\Provider\GorvodokanalProvider;
use PHPUnit\Framework\TestCase;

final class GorvodokanalProviderTest extends TestCase
{
    public function testProviderData(): GorvodokanalProvider
    {
        $provider = new GorvodokanalProvider('https://www.gorvodokanal.com/abonents/tariffs/', true);
        self::assertEquals('Горводоканал', $provider->getOrganizationName());

        $service1 = $provider->getServiceByKey($provider->generateServiceKey('1'));
        self::assertEquals('Холодная вода', $service1->getName());
        self::assertEquals('28.14', $service1->getTax());
        self::assertEquals('За метр кубический', $service1->getUnit());

        $service2 = $provider->getServiceByKey($provider->generateServiceKey('2'));
        self::assertEquals('Водоотведение', $service2->getName());
        self::assertEquals('23.75', $service2->getTax());
        self::assertEquals('За метр кубический', $service2->getUnit());

        return $provider;
    }

    /**
     * @depends testProviderData
     */
    public function testIsActualServicesTaxes(GorvodokanalProvider $provider): void
    {
        $taxes = $provider->parseServicesTaxes();

        foreach ($taxes as $serviceKey => $tax) {
            self::assertEquals($provider->getServiceByKey($serviceKey)->getTax(), $tax);
        }
    }
}