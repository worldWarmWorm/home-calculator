<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use simplehtmldom\HtmlWeb;
use HomeCalculator\Provider\Driver\{
    Provider,
    Service
};

final class AOSAHProvider extends Provider
{
    public function __construct(string $url)
    {
        $this->loadInfo($url);
    }

    #[\Override]
    public function loadInfo(string $url): void
    {
        $html = (new HtmlWeb())->load($url);
        $this->url = $url;
        $this->organizationName = preg_replace('/Тарифы - /', '', $html->find('head title', 0)->plaintext);

        preg_match(
            '/\d+,\d+/',
            $html->find('body div.body div.main div.container div.tariffs-page div.styled-block ul li strong', 8)->plaintext,
            $tax
        );

        $this->services = [
            new Service(
                self::generateServiceKey('1'),
                'Обращение с ТКО',
                isset($tax[0]) ? (float)str_replace(',', '.', $tax[0]) : 0,
                'с одного человека, прописанного в квартире'
            )
        ];
    }
}