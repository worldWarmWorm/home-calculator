<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use HomeCalculator\Provider\Driver\Provider;
use HomeCalculator\Provider\Driver\Service;
use simplehtmldom\HtmlWeb;

class ModernizationFundProvider extends Provider
{
    public function __construct(string $url)
    {
        $this->loadInfo($url);
    }

    public function loadInfo(string $url): void
    {
        $html = (new HtmlWeb())->load($url);
        $this->url = '';
        $this->organizationName = '';
        $this->services = [
            new Service(
                'Водоотведение на содержание общего имущества',
                0,
                ''
            ),
            new Service(
                'ХВС на содержание общего имущества',
                0,
                ''
            ),
            new Service(
                'Текущее содержание',
                0,
                ''
            ),
            new Service(
                'ГВС на содержание общего имущества',
                0,
                ''
            ),
            new Service(
                'Электроэнергия на содержание общего имущества',
                0,
                ''
            ),
            new Service(
                'ХВС на ГВС СОИ',
                0,
                ''
            ),
            new Service(
                'Текущий ремонт',
                0,
                ''
            ),
        ];
    }
}