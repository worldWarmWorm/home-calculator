<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use HomeCalculator\Provider\Driver\{Provider, ProviderInterface};

class ModernizationFundProvider extends Provider
{
    public function __construct(string $url)
    {
        $this->url = $url;
        $this->fixedTaxExplain = '';
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

    public function parseInfo(string $url, array $props): array
    {
        return [];
    }
}