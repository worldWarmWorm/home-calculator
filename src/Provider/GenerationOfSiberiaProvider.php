<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use HomeCalculator\Driver\Provider;
use HomeCalculator\Driver\Service;
use HomeCalculator\Logger\Log;
use HomeCalculator\Storage\Storage;
use Monolog\Level;

class GenerationOfSiberiaProvider extends Provider
{
    public function __construct(string $url)
    {
        $this->organizationName = 'ООО "Генерация Сибири"';
        $this->url = $url;
        $this->storage = Storage::getInstance();
        $this->actualizeServicesTaxes();
        $keys = array_keys($this->getKeySelectorPairs());
        $this->services = [
            new Service(
                $keys[0],
                'Электрическая энергия',
                $this->storage->read($this->organizationName, $keys[0]),
                'кВт/ч'
            )
        ];
        Log::create(self::class . ' constructor called', Level::Info);
    }

    public function getKeySelectorPairs(): array
    {
        return [
            $this->generateServiceKey('1') => '#eael-advance-tabs-05e5405 > div.eael-tabs-content div:nth-child(2) > table > tbody > tr:nth-child(5) > td:nth-child(2)',
        ];
    }
}