<?php

declare(strict_types=1);

namespace HomeCalculator\Tests;

use HomeCalculator\Provider\GenerationOfSiberiaProvider;
use PHPUnit\Framework\TestCase;

final class GenerationOfSiberiaProviderTest extends TestCase
{
    public function testProviderData(): GenerationOfSiberiaProvider
    {
        $provider = new GenerationOfSiberiaProvider('https://gensib54.ru/', true);
        self::assertEquals('ООО "Генерация Сибири"', $provider->getOrganizationName());

        $service1 = $provider->getServiceByKey($provider->generateServiceKey('1'));
        self::assertEquals('Электрическая энергия', $service1->getName());
        self::assertEquals('4.12', $service1->getTax());
        self::assertEquals('кВт/ч', $service1->getUnit());

        $service2 = $provider->getServiceByKey($provider->generateServiceKey('2'));
        self::assertEquals('Тепловая энергия', $service2->getName());
        self::assertEquals('2235.56', $service2->getTax());
        self::assertEquals('Гкал', $service2->getUnit());

        $service3 = $provider->getServiceByKey($provider->generateServiceKey('3'));
        self::assertEquals('Горячая вода', $service3->getName());
        self::assertEquals('179.69', $service3->getTax());
        self::assertEquals('За метр кубический', $service3->getUnit());

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