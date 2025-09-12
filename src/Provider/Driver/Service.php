<?php

declare(strict_types=1);

namespace HomeCalculator\Provider\Driver;

final readonly class Service
{
    public function __construct(
        private string $key,
        private string $name,
        private float  $tax,
        private string $unit
    ) {
    }
    public function getKey(): string
    {
        return $this->key;
    }

    public function getTax(): float
    {
        return $this->tax;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }
}