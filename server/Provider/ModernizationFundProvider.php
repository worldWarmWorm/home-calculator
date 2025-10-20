<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use HomeCalculator\Driver\Provider;
use HomeCalculator\Driver\Service;
use HomeCalculator\DTO\FormInputMultiplier;

final class ModernizationFundProvider extends Provider
{
    public function __construct(string $url)
    {
        parent::__construct($url, 'Фонд модернизации ЖКХ');

        $this->services = [
            new Service(
                $this->serviceKeys[0],
                'Взнос за капитальный ремонт',
                $this->getTaxStorage()->read($this->organizationName, $this->serviceKeys[0]),
                'за 1 кв.м площади квартиры',
                [
                    new FormInputMultiplier(
                        'Площадь квартиры',
                        'square-of-house',
                        'кв.м'
                    )
                ]
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