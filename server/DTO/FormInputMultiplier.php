<?php

declare(strict_types=1);

namespace HomeCalculator\DTO;

final readonly class FormInputMultiplier
{
    public function __construct(
        private string $label,
        private string $name,
        private string $measure
    ) {
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMeasure(): string
    {
        return $this->measure;
    }
}