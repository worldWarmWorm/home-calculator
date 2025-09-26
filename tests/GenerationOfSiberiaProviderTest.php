<?php

declare(strict_types=1);

namespace HomeCalculator\Tests;

use HomeCalculator\Provider\GenerationOfSiberiaProvider;
use PHPUnit\Framework\TestCase;

final class GenerationOfSiberiaProviderTest extends TestCase
{
    public function testProviderData(): GenerationOfSiberiaProvider
    {
        $provider = new GenerationOfSiberiaProvider('https://gensib54.ru/');
        self::assertEquals('ООО "Генерация Сибири"', $provider->getOrganizationName());
        $service = $provider->getServiceByKey($provider->generateServiceKey('1'));
        self::assertEquals('Электрическая энергия', $service->getName());
        self::assertEquals('4.12', $service->getTax());
        self::assertEquals('кВт/ч', $service->getUnit());

        return $provider;
    }

    /**
     * @depends testProviderData
     */
    public function testIsActualServicesTaxes(GenerationOfSiberiaProvider $provider): void
    {
        $taxes = $provider->parseServicesTaxes();

        foreach ($taxes as $serviceKey => $tax) {
            self::assertEquals($provider->getServiceByKey($serviceKey)->getTax(), $tax);
        }
    }
}