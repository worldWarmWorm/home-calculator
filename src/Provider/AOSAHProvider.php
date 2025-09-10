<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use HomeCalculator\Provider\Driver\{Provider, ProviderInterface};
use simplehtmldom\HtmlWeb;

final class AOSAHProvider extends Provider
{
    public function __construct(string $url)
    {
        $this->url = $url;
        $this->fixedTaxExplain = 'с одного человека, прописанного в квартире';
        $info = $this->parseInfo(
            $this->url,
            [
                ProviderInterface::NAME,
                ProviderInterface::TAX,
                ProviderInterface::MEASURE
            ]
        );
        $this->name = $info['name'];
        $this->tax = $info['tax'];
        $this->measure = $info['measure'];
    }

    #[\Override]
    public function parseInfo(string $url, array $props): array
    {
        $html = (new HtmlWeb())->load($url);
        $name = preg_replace('/Тарифы - /', '', $html->find('head title', 0)->plaintext);
        $taxAndMeasureRaw = $html->find('body div.body div.main div.container div.tariffs-page div.styled-block ul li strong', 8)->plaintext;
        preg_match('/\d+,\d+/', $taxAndMeasureRaw, $tax);
        preg_match('/[а-я]+/u', $taxAndMeasureRaw, $measure);

        return [
            ProviderInterface::NAME => $name,
            ProviderInterface::TAX => isset($tax[0]) ? (float)str_replace(',', '.', $tax[0]) : 0,
            ProviderInterface::MEASURE => $measure[0] ?? '',
        ];
    }
}