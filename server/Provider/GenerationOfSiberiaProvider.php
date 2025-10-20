<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use HomeCalculator\Driver\Provider;
use HomeCalculator\Driver\Service;
use HomeCalculator\DTO\FormInputMultiplier;

final class GenerationOfSiberiaProvider extends Provider
{
    public function __construct(string $url, bool $isUnitTest = false)
    {
        parent::__construct($url, 'ООО "Генерация Сибири"', $isUnitTest);

        $this->services = [
            new Service(
                $this->serviceKeys[0],
                'Электрическая энергия',
                $this->getTaxStorage()->read($this->organizationName, $this->serviceKeys[0]),
                'кВт/ч',
                [
                    new FormInputMultiplier(
                        'Электричество',
                        'electricity',
                        'кВт/ч'
                    )
                ]
            ),
            new Service(
                $this->serviceKeys[1],
                'Тепловая энергия',
                $this->getTaxStorage()->read($this->organizationName, $this->serviceKeys[1]),
                'Гкал',
                [
                    new FormInputMultiplier(
                        'Количество',
                        'warm',
                        'Гкал'
                    )
                ]
            ),
            new Service(
                $this->serviceKeys[2],
                'Горячая вода',
                $this->getTaxStorage()->read($this->organizationName, $this->serviceKeys[2]),
                "За метр кубический",
                [
                    new FormInputMultiplier(
                        'Объем',
                        'hot-water',
                        'м.куб'
                    )
                ]
            )
        ];
    }

    public static function getKeySelectorPairs(): array
    {
        $parent = '#eael-advance-tabs-05e5405 > div.eael-tabs-content div:nth-child(2) > table > tbody';

        return [
            self::generateServiceKey('1') => "$parent > tr:nth-child(5) > td:nth-child(2)",
            self::generateServiceKey('2') => "$parent > tr:nth-child(13) > td:nth-child(2)",
            self::generateServiceKey('3') => "$parent > tr:nth-child(15) > td:nth-child(2)",
        ];
    }
}