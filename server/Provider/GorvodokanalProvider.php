<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use HomeCalculator\Driver\Multiplier;
use HomeCalculator\Driver\Provider;
use HomeCalculator\Driver\Service;
use HomeCalculator\Logger\Log;
use HomeCalculator\Storage\Storage;
use Monolog\Level;

final class GorvodokanalProvider extends Provider
{
    public function __construct(string $url)
    {
        $this->organizationName = 'Горводоканал';
        $this->url = $url;
        $this->storage = Storage::getInstance();
        $this->actualizeServicesTaxes();
        $keys = array_keys($this->getKeySelectorPairs());
        $this->services = [
            new Service(
                $keys[0],
                'Холодная вода',
                $this->storage->read($this->organizationName, $keys[0]),
                "За метр кубический",
                [
                    new Multiplier(
                        'Объем',
                        'cold-water',
                        'м.куб'
                    )
                ]
            ),
            new Service(
                $keys[1],
                'Водоотведение',
                $this->storage->read($this->organizationName, $keys[1]),
                "За метр кубический",
                [
                    new Multiplier(
                        'Объем',
                        'water-aside',
                        'м.куб'
                    )
                ]
            )
        ];
        Log::create(self::class . ' constructor called', Level::Info);
    }

    public function getKeySelectorPairs(): array
    {
        $parent = 'body > main > div > div > div.div-flex > div.subpage > div > details:nth-child(2) > div > div > div.table-tariff__body > div:nth-child(1)';

        return [
            $this->generateServiceKey('1') => "$parent > div:nth-child(2)",
            $this->generateServiceKey('2') => "$parent > div:nth-child(3)",
        ];
    }
}