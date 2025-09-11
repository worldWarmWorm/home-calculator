<?php

namespace HomeCalculator\Provider\Driver;

interface ProviderInterface
{
    public function loadInfo(string $url): void;
}