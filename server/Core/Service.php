<?php

declare(strict_types=1);

namespace HomeCalculator\Core;

use HomeCalculator\DTO\FormInputMultiplier;

final readonly class Service
{
    /**
     * @param list<FormInputMultiplier> $multipliers
     */
    public function __construct(
        private string $key,
        private string $name,
        private ?float  $tax,
        private string $unit,
        private array $multipliers
    ) {
    }
    public function getKey(): string
    {
        return $this->key;
    }

    public function getTax(): ?float
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

    /**
     * @return list<FormInputMultiplier>
     */
    public function getMultipliers(): array
    {
        return $this->multipliers;
    }
}