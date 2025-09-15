<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use HomeCalculator\Driver\Provider;

final class GenerationOfSiberiaProvider extends Provider
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