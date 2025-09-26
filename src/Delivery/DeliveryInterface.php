<?php

declare(strict_types=1);

namespace HomeCalculator\Delivery;

interface DeliveryInterface
{
    public function send(): string;
}