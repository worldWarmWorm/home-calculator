<?php

declare(strict_types=1);

namespace HomeCalculator\DTO;

final readonly class ServiceDto
{
    /**
     * @param list<FormInputMultiplierDto>|FormInputMultiplierDto $multipliers
     */
    public function __construct(
        private string $key,
        private string $name,
        private ?float  $tax,
        private string $unit,
        private array|FormInputMultiplierDto $multipliers
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
     * @return list<FormInputMultiplierDto>|FormInputMultiplierDto
     */
    public function getMultipliers(): array|FormInputMultiplierDto
    {
        return is_array($this->multipliers) ? $this->multipliers : [$this->multipliers];
    }
}