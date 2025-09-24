<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use DateInvalidTimeZoneException;
use DateMalformedStringException;
use HomeCalculator\Driver\Parser;
use HomeCalculator\Driver\Provider;
use HomeCalculator\Driver\ProviderException;
use HomeCalculator\Driver\Service;
use HomeCalculator\Driver\TimezoneEnum;
use HomeCalculator\Logger\Log;
use HomeCalculator\Storage\Storage;
use Monolog\Level;

final class AOSAHProvider extends Provider
{
    /**
     * @throws DateMalformedStringException
     * @throws DateInvalidTimeZoneException
     */
    public function __construct(string $url)
    {
        $this->organizationName = 'АО "САХ"';
        $this->url = $url;
        $this->storage = Storage::getInstance();
        $this->actualizeServicesTaxes();
        $keys = $this->getRegisteredServicesKeys();
        $this->services = [
            new Service(
                $keys[0],
                'Обращение с ТКО',
                $this->storage->read($this->organizationName, $keys[0]),
                'с одного человека, прописанного в квартире'
            )
        ];
        Log::create(self::class . ' constructor called', Level::Info);
    }

    public function parseServicesTaxes(): array
    {
        $parser = new Parser();
        $serviceKeys = $this->getRegisteredServicesKeys();
        $callbacks = [];

        foreach ($serviceKeys as $serviceKey) {
            $callbacks[$serviceKey] = match ($serviceKey) {
                $serviceKeys[0] => fn(): ?float => $parser->parseTax(
                    $this->url,
                    ''
                ),
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

    public function getRegisteredServicesKeys(): array
    {
        return [
            $this->generateServiceKey('1'),
        ];
    }
}