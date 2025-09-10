<?php

declare(strict_types=1);

namespace HomeCalculator\Provider\Driver;

abstract class Provider implements ProviderInterface
{
    protected string $name;

    protected string $url;

    protected float $tax;

    protected string $measure;

    protected ?string $fixedTaxExplain = null;

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTax(): float
    {
        return $this->tax;
    }

    public function getMeasure(): string
    {
        return $this->measure;
    }

    public function getFixedTaxExplain(): ?string
    {
        return $this->fixedTaxExplain;
    }
}