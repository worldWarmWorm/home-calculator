<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

final class GorskiyProvider extends Driver\Provider
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