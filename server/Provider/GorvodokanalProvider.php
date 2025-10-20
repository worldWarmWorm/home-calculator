<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use HomeCalculator\DTO\FormInputMultiplierDto;
use HomeCalculator\DTO\ServiceDto;
use HomeCalculator\Provider\Core\Provider;

final class GorvodokanalProvider extends Provider
{
    public function __construct(string $url, bool $isUnitTest = false)
    {
        parent::__construct($url, 'Горводоканал', $isUnitTest);

        $this->services = [
            new ServiceDto(
                $this->serviceKeys[0],
                'Холодная вода',
                $this->getTaxStorage()->read($this->organizationName, $this->serviceKeys[0]),
                "За метр кубический",
                new FormInputMultiplierDto(
                    'Объем',
                    'cold-water',
                    'м.куб'
                )
            ),
            new ServiceDto(
                $this->serviceKeys[1],
                'Водоотведение',
                $this->getTaxStorage()->read($this->organizationName, $this->serviceKeys[1]),
                "За метр кубический",
                new FormInputMultiplierDto(
                    'Объем',
                    'water-aside',
                    'м.куб'
                )
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