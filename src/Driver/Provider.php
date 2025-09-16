<?php

declare(strict_types=1);

namespace HomeCalculator\Driver;

abstract class Provider implements ProviderInterface
{
    protected string $organizationName;

    protected string $url;

    /**
     * @var array<int, Service>
     */
    protected array $services;

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getOrganizationName(): string
    {
        return $this->organizationName;
    }

    /**
     * @return array<Service>
     */
    public function getServices(): array
    {
        return $this->services;
    }

    public function generateServiceKey(string $uniqId): string
    {
        return static::class . ':service:' . $uniqId;
    }
}