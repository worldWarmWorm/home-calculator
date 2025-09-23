<?php

declare(strict_types=1);

namespace HomeCalculator\Driver;

use DateInvalidTimeZoneException;
use DateMalformedStringException;
use DateTimeImmutable;
use DateTimeZone;
use HomeCalculator\Storage\Storage;

abstract class Provider implements ProviderInterface
{
    protected string $organizationName;

    protected string $url;

    /**
     * @var array<int, Service>
     */
    protected array $services;

    protected Storage $storage;

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

    public function getServiceByKey(string $key): Service
    {
        $service = array_filter(
            $this->services,
            fn(Service $service) => $service->getKey() === $key
        )[0] ?? null;

        if (null === $service) {
            throw new ProviderException("Service with key $key not found");
        }

        return $service;
    }

    /**
     * @throws DateMalformedStringException
     * @throws DateInvalidTimeZoneException
     */
    protected function isTimeToUpdateServicesTaxes(string $timezone): bool
    {
        $tz = new DateTimeZone($timezone);
        $now = new DateTimeImmutable(timezone: $tz);
        $lastParseDate = $now->format('Y-m-d');
        $filename = __DIR__ . '/../../last_parse_date.txt';

        if (!file_exists($filename)) {
            file_put_contents($filename, $lastParseDate);
            return true;
        }

        $prevDate = file_get_contents($filename);

        if ($prevDate === (new DateTimeImmutable(timezone: $tz))->format('Y-m-d')) {
            return false;
        } else {
            file_put_contents($filename, $lastParseDate);
            return true;
        }
    }

    protected function isTaxesExists(ProviderInterface $provider): bool
    {
        $storage = Storage::getInstance();

        foreach ($provider->getServices() as $service) {
            $tax = $storage->read($provider->getOrganizationName(), $service->getKey());

            if (null === $tax) {
                return true;
            }
        }

        return false;
    }
}