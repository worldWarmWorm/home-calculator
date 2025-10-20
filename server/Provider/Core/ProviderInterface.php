<?php

namespace HomeCalculator\Provider\Core;

interface ProviderInterface
{
    /**
     * @return array<string, string>
     */
    public static function getKeySelectorPairs(): array;
}