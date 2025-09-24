<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use DateInvalidTimeZoneException;
use DateMalformedStringException;
use HomeCalculator\Driver\Parser;
use HomeCalculator\Driver\Provider;
use HomeCalculator\Driver\ProviderException;
use HomeCalculator\Driver\ProviderInterface;
use HomeCalculator\Driver\Service;
use HomeCalculator\Driver\TimezoneEnum;
use HomeCalculator\Logger\Log;
use HomeCalculator\Storage\Storage;
use Monolog\Level;

final class ModernizationFundProvider extends Provider
{
    public function __construct(string $url)
    {
        $this->organizationName = 'Фонд модернизации ЖКХ';
        $this->url = $url;
        $this->storage = Storage::getInstance();
        $this->actualizeServicesTaxes($this->organizationName);
        $keys = $this->getRegisteredServicesKeys();
        $this->services = [
            new Service(
                $keys[0],
                'Взнос за капитальный ремонт',
                $this->storage->read($this->organizationName, $keys[0]),
                'за 1 кв.м площади квартиры'
            )
        ];
        Log::create(self::class . ' constructor called', Level::Info);
    }

    public function getRegisteredServicesKeys(): array
    {
        return [
            $this->generateServiceKey('1'),
        ];
    }

    public function parseServicesTaxes(): array
    {
        $parser = new Parser();
        $serviceKeys = $this->getRegisteredServicesKeys();
        $callbacks = [];

        foreach ($serviceKeys as $serviceKey) {
            $callbacks[$serviceKey] = match ($serviceKey) {
                $serviceKeys[0] => fn(): float => $parser->parseTax($this->url, 'body > div.wrap.container-fluid > div > main > section > div.col-lg-8 > div.row > div.col-xs-9 > ul:nth-child(3) > li:nth-child(3)'),
                default => throw new ProviderException("Service key \"$serviceKey\" not found"),
            };
        }

        $taxes = [];

        foreach ($serviceKeys as $serviceKey) {
            $taxes[$serviceKey] = $callbacks[$serviceKey]();
            Log::create("Parsed tax $taxes[$serviceKey] by key $serviceKey", Level::Info);
        }

        return $taxes;
    }
}