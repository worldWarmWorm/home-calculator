<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

abstract class Provider implements ProviderInterface
{
    protected string $name;

    protected string $url;

    protected int $tax;

    protected string $measure;

    public function __construct(string $url)
    {
        $this->url = $url;
        $info = $this->parseInfo(
            $this->url,
            [
                ProviderInterface::NAME,
                ProviderInterface::TAX,
                ProviderInterface::MEASURE
            ]
        );
        $this->name = $info['name'];
        $this->measure = $info['measure'];
        $this->tax = $info['tax'];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getTax(): int
    {
        return $this->tax;
    }

    public function getMeasure(): string
    {
        return $this->measure;
    }
}