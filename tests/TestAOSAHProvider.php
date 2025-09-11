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
        $name = $provider->getOrganizationName();
        $tax = $provider->getTax();

        self::assertEquals('АО «САХ»', $name);
        self::assertEquals('91.52', $tax);
        self::assertEquals('руб', $measure);
    }
}