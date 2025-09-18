<?php

namespace HomeCalculator\Driver;

use DateInvalidTimeZoneException;
use DateMalformedStringException;

interface ProviderInterface
{
    /**
     * @return  array{
     *     organizationName: string,
     *     url: string,
     *     services: array<int, Service>
     * }
     */
    public function loadCard(): array;

    /**
     * @throws DateMalformedStringException
     * @throws DateInvalidTimeZoneException
     */
    public function actualizeServicesTaxes(): void;
}