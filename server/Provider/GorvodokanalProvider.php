<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use HomeCalculator\Driver\Provider;
use HomeCalculator\Driver\Service;
use HomeCalculator\DTO\FormInputMultiplier;

final class GorvodokanalProvider extends Provider
{
    public function __construct(string $url)
    {
        parent::__construct($url, 'Горводоканал');

        $this->services = [
            new Service(
                $this->serviceKeys[0],
                'Холодная вода',
                $this->getTaxStorage()->read($this->organizationName, $this->serviceKeys[0]),
                "За метр кубический",
                [
                    new FormInputMultiplier(
                        'Объем',
                        'cold-water',
                        'м.куб'
                    )
                ]
            ),
            new Service(
                $this->serviceKeys[1],
                'Водоотведение',
                $this->getTaxStorage()->read($this->organizationName, $this->serviceKeys[1]),
                "За метр кубический",
                [
                    new FormInputMultiplier(
                        'Объем',
                        'water-aside',
                        'м.куб'
                    )
                ]
            )
        ];
    }

    public static function getKeySelectorPairs(): array
    {
        $parent = 'body > main > div > div > div.div-flex > div.subpage > div > details:nth-child(2) > div > div > div.table-tariff__body > div:nth-child(1)';

        return [
            self::generateServiceKey('1') => "$parent > div:nth-child(2)",
            self::generateServiceKey('2') => "$parent > div:nth-child(3)",
        ];
    }
}