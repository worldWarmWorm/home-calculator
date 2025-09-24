<?php

declare(strict_types=1);

namespace HomeCalculator\Driver;

use DateInvalidTimeZoneException;
use DateMalformedStringException;
use DateTimeImmutable;
use DateTimeZone;
use HomeCalculator\Logger\Log;
use HomeCalculator\Storage\Storage;
use Monolog\Level;

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

    protected function isTaxesExists(string $organizationName, array $serviceKeys): bool
    {
        $storage = Storage::getInstance();

        foreach ($serviceKeys as $serviceKey) {
            $tax = $storage->read($organizationName, $serviceKey);

            if (null === $tax) {
                return false;
            }
        }

        return true;
    }

    public function actualizeServicesTaxes(): void
    {
        if (
            false === $this->isTaxesExists($this->organizationName, $this->getRegisteredServicesKeys())
            || true === $this->isTimeToUpdateServicesTaxes(TimezoneEnum::NOVOSIBIRSK->value)
        ) {
            foreach ($this->parseServicesTaxes() as $serviceKey => $tax) {
                if (null === $tax) {
                    Log::create("Can't parse tax by serviceKey $serviceKey. Look provider's page: $this->url", Level::Error);
                    // @TODO add notification via sms or telergam

                    continue;
                }

                $this->storage->write($this->organizationName, [$serviceKey => $tax]);
            }
        }
    }
}