<?php

namespace HomeCalculator\Driver;

interface ProviderInterface
{
    /**
     * @return array<string, string>
     */
    public function getKeySelectorPairs(): array;
}