<?php

namespace HomeCalculator\Driver;

interface ProviderInterface
{
    /**
     * @return array<string, string>
     */
    public static function getKeySelectorPairs(): array;
}