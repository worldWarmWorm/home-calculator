<?php

declare(strict_types=1);

namespace HomeCalculator\Tests;

use HomeCalculator\Provider\ModernizationFundProvider;
use PHPUnit\Framework\TestCase;

class TestModernizationFundProvider extends TestCase
{
    public function testParsedContent(): void
    {
        $provider = new ModernizationFundProvider('https://www.fondgkh-nso.ru/');
        self::assertEquals('АО «САХ»', $provider->getOrganizationName());

        $service1 = $provider->getServiceById('1');
        self::assertEquals('Обращение с ТКО', $service1->getName());
        self::assertEquals('91.52', $service1->getTax());

        $service2 = $provider->getServiceById('2');
        self::assertEquals('Обращение с ТКО', $service2->getName());
        self::assertEquals('91.52', $service2->getTax());

        $service3 = $provider->getServiceById('3');
        self::assertEquals('Обращение с ТКО', $service3->getName());
        self::assertEquals('91.52', $service3->getTax());

        $service4 = $provider->getServiceById('4');
        self::assertEquals('Обращение с ТКО', $service4->getName());
        self::assertEquals('91.52', $service4->getTax());

        $service5 = $provider->getServiceById('5');
        self::assertEquals('Обращение с ТКО', $service5->getName());
        self::assertEquals('91.52', $service5->getTax());

        $service6 = $provider->getServiceById('6');
        self::assertEquals('Обращение с ТКО', $service6->getName());
        self::assertEquals('91.52', $service6->getTax());

        $service7 = $provider->getServiceById('7');
        self::assertEquals('Обращение с ТКО', $service7->getName());
        self::assertEquals('91.52', $service7->getTax());
    }
}