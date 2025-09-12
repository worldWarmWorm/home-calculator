<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use HomeCalculator\Provider\Driver\Provider;

final class GorvodokanalProvider extends Provider
{
    public function __construct(string $url)
    {
        $this->loadInfo($url);
    }

    public function loadInfo(string $url): void
    {
        // TODO: Implement loadInfo() method.
    }
}