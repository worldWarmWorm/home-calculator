<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use HomeCalculator\Driver\Multiplier;
use HomeCalculator\Driver\Provider;
use HomeCalculator\Driver\Service;
use HomeCalculator\Logger\Log;
use HomeCalculator\Storage\TaxStorage;
use Monolog\Level;

final class ModernizationFundProvider extends Provider
{
    public function __construct(string $url)
    {
        $this->organizationName = 'Фонд модернизации ЖКХ';
        $this->url = $url;
        $this->storage = TaxStorage::getInstance();
        $this->actualizeServicesTaxes();
        $keys = array_keys($this->getKeySelectorPairs());
        $this->services = [
            new Service(
                $keys[0],
                'Взнос за капитальный ремонт',
                $this->storage->read($this->organizationName, $keys[0]),
                'за 1 кв.м площади квартиры',
                [
                    new Multiplier(
                        'Площадь квартиры',
                        'square-of-house',
                        'кв.м'
                    )
                ]
            )
        ];
        Log::create(self::class . ' constructor called', Level::Info);
    }

    public function getKeySelectorPairs(): array
    {
        return [
            $this->generateServiceKey('1') => 'body > div.wrap.container-fluid > div > main > section > div.col-lg-8 > div.row > div.col-xs-9 > ul:nth-child(3) > li:nth-child(3)',
        ];
    }
}