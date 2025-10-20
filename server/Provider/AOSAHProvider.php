<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use HomeCalculator\Driver\Provider;
use HomeCalculator\Driver\Service;
use HomeCalculator\DTO\FormInputMultiplier;

final class AOSAHProvider extends Provider
{
    public function __construct(string $url)
    {
        parent::__construct($url, 'АО "САХ"');

        $this->services = [
            new Service(
                $this->serviceKeys[0],
                'Обращение с ТКО',
                $this->getTaxStorage()->read($this->organizationName, $this->serviceKeys[0]),
                'чел',
                [
                    new FormInputMultiplier(
                        'Человек в квартире',
                        'humans-in-house',
                        'чел'
                    )
                ]
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