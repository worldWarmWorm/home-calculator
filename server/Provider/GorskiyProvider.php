<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use HomeCalculator\Core\Provider;
use HomeCalculator\Core\Service;
use HomeCalculator\DTO\FormInputMultiplier;

final class GorskiyProvider extends Provider
{
    public function __construct(string $url, bool $isUnitTest = false)
    {
        parent::__construct($url, 'ООО "КЖЭК Горский"', $isUnitTest);

        $this->services = [
            new Service(
                $this->serviceKeys[0],
                'Текущее содержание',
                (float)'32.23', // @todo need parse
                "За метр квадратный",
                [
                    new FormInputMultiplier(
                        'Площадь квартиры',
                        'current-maintenance',
                        'кв.м'
                    )
                ]
            ),
            new Service(
                $this->serviceKeys[1],
                'Текущий ремонт',
                (float)'3', // @todo need parse
                "За метр квадратный",
                [
                    new FormInputMultiplier(
                        'Площадь квартиры',
                        'current-repairs',
                        'кв.м'
                    )
                ]
            ),
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