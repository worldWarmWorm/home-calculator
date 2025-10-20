<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use HomeCalculator\DTO\FormInputMultiplierDto;
use HomeCalculator\DTO\ServiceDto;
use HomeCalculator\Provider\Core\Provider;

final class AOSAHProvider extends Provider
{
    public function __construct(string $url, bool $isUnitTest = false)
    {
        parent::__construct($url, 'АО "САХ"', $isUnitTest);

        $this->services = [
            new ServiceDto(
                $this->serviceKeys[0],
                'Обращение с ТКО',
                $this->getTaxStorage()->read($this->organizationName, $this->serviceKeys[0]),
                'чел',
                new FormInputMultiplierDto(
                    'Человек в квартире',
                    'humans-in-house',
                    'чел'
                )
            )
        ];
    }

    public static function getKeySelectorPairs(): array
    {
        return [
            self::generateServiceKey('1') => 'body > div.body > div.main > div:nth-child(2) > div.tariffs-page > div:nth-child(1) > ul > li:nth-child(6) > strong:nth-child(2)',
        ];
    }
}