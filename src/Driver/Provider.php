<?php

declare(strict_types=1);

namespace HomeCalculator\Driver;

use DateInvalidTimeZoneException;
use DateMalformedStringException;
use DateTimeImmutable;
use DateTimeZone;

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

    /**
     * @throws DateMalformedStringException
     * @throws DateInvalidTimeZoneException
     */
    protected function isTimeToUpdateTax(string $timezone = 'Asia/Novosibirsk'): bool
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
}