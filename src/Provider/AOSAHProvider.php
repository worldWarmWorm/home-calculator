<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use simplehtmldom\HtmlWeb;

final class AOSAHProvider extends Provider
{
    #[\Override]
    public function parseInfo(string $url, array $props): array
    {
        $html = (new HtmlWeb())->load($url);
        $name = preg_replace('/Тарифы - /', '', $html->find('head title', 0)->plaintext);
        $tax = $html->find('.tariffs-page .styled-block ul li strong')->plaintext;

        return [
            ProviderInterface::NAME => $name,
            ProviderInterface::TAX => $tax,
            ProviderInterface::MEASURE => "",
        ];
    }
}