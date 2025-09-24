<?php

namespace HomeCalculator\Driver;

interface ProviderInterface
{
    /**
     * @return array<int, string>
     */
    public function getRegisteredServicesKeys(): array;

    /**
     * @return array<int, float>
     */
    public function parseServicesTaxes(): array;
}