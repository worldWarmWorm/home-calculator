<?php

namespace HomeCalculator\Driver;

interface ProviderInterface
{
    public function loadCard(): array;
}