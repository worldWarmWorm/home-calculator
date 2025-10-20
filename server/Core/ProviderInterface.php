<?php

namespace HomeCalculator\Core;

interface ProviderInterface
{
    /**
     * @return array<string, string>
     */
    public static function getKeySelectorPairs(): array;
}