<?php

namespace HomeCalculator\Driver;

use DateInvalidTimeZoneException;
use DateMalformedStringException;

interface ProviderInterface
{
    /**
     * @throws DateMalformedStringException
     * @throws DateInvalidTimeZoneException
     */
    public function actualizeServicesTaxes(): void;
}