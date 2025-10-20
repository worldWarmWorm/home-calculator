<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use HomeCalculator\DTO\FormInputMultiplierDto;
use HomeCalculator\DTO\ServiceDto;
use HomeCalculator\Provider\Core\Provider;

final class ModernizationFundProvider extends Provider
{
    public function __construct(string $url, bool $isUnitTest = false)
    {
        parent::__construct($url, 'Фонд модернизации ЖКХ', $isUnitTest);

        $this->services = [
            new ServiceDto(
                $this->serviceKeys[0],
                'Взнос за капитальный ремонт',
                $this->getTaxStorage()->read($this->organizationName, $this->serviceKeys[0]),
                'за 1 кв.м площади квартиры',
                new FormInputMultiplierDto(
                    'Площадь квартиры',
                    'square-of-house',
                    'кв.м'
                )
            )
        ];
    }

    public static function getKeySelectorPairs(): array
    {
        return [
            self::generateServiceKey('1') => 'body > div.wrap.container-fluid > div > main > section > div.col-lg-8 > div.row > div.col-xs-9 > ul:nth-child(3) > li:nth-child(3)',
        ];
    }
}