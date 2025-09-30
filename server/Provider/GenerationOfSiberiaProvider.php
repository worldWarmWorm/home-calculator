<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use HomeCalculator\Driver\Provider;
use HomeCalculator\Driver\Service;
use HomeCalculator\Logger\Log;
use HomeCalculator\Storage\Storage;
use Monolog\Level;

final class GenerationOfSiberiaProvider extends Provider
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
            ),
            new Service(
                $keys[1],
                'Тепловая энергия',
                $this->storage->read($this->organizationName, $keys[1]),
                'Гкал'
            ),
            new Service(
                $keys[2],
                'Горячая вода',
                $this->storage->read($this->organizationName, $keys[2]),
                "За метр кубический"
            )
        ];
        Log::create(self::class . ' constructor called', Level::Info);
    }

    public function getKeySelectorPairs(): array
    {
        $parent = '#eael-advance-tabs-05e5405 > div.eael-tabs-content div:nth-child(2) > table > tbody';

        return [
            $this->generateServiceKey('1') => "$parent > tr:nth-child(5) > td:nth-child(2)",
            $this->generateServiceKey('2') => "$parent > tr:nth-child(13) > td:nth-child(2)",
            $this->generateServiceKey('3') => "$parent > tr:nth-child(15) > td:nth-child(2)",
        ];
    }
}