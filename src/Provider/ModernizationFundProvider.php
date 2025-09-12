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
                $this->generateServiceKey('1'),
                'Водоотведение на содержание общего имущества',
                0,
                ''
            ),
            new Service(
                $this->generateServiceKey('2'),
                'ХВС на содержание общего имущества',
                0,
                ''
            ),
            new Service(
                $this->generateServiceKey('3'),
                'Текущее содержание',
                0,
                ''
            ),
            new Service(
                $this->generateServiceKey('4'),
                'ГВС на содержание общего имущества',
                0,
                ''
            ),
            new Service(
                $this->generateServiceKey('5'),
                'Электроэнергия на содержание общего имущества',
                0,
                ''
            ),
            new Service(
                $this->generateServiceKey('6'),
                'ХВС на ГВС СОИ',
                0,
                ''
            ),
            new Service(
                $this->generateServiceKey('7'),
                'Текущий ремонт',
                0,
                ''
            ),
        ];
    }
}