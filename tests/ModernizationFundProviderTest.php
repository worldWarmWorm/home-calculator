<?php

declare(strict_types=1);

namespace HomeCalculator\Tests;

use HomeCalculator\Provider\ModernizationFundProvider;
use PHPUnit\Framework\TestCase;

class ModernizationFundProviderTest extends TestCase
{
    public function testProviderData(): ModernizationFundProvider
    {
        $provider = new ModernizationFundProvider('https://www.fondgkh-nso.ru/oplata_vznosov/');
        self::assertEquals('Фонд модернизации ЖКХ', $provider->getOrganizationName());
        $service = $provider->getServiceByKey($provider->generateServiceKey('1'));
        self::assertEquals('Взнос за капитальный ремонт', $service->getName());
        self::assertEquals('19.29', $service->getTax());
        self::assertEquals('за 1 кв.м площади квартиры', $service->getUnit());

        return $provider;
    }

    /**
     * @depends testProviderData
     */
    public function testIsActualServicesTaxes(ModernizationFundProvider $provider): void
    {
        $taxes = $provider->parseServicesTaxes();

        foreach ($taxes as $serviceKey => $tax) {
            self::assertEquals($provider->getServiceByKey($serviceKey)->getTax(), $tax);
        }
    }
}