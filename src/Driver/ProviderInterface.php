<?php

namespace HomeCalculator\Driver;

interface ProviderInterface
{
    public function loadInfo(string $url): void;
}