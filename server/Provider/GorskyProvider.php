<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use HomeCalculator\Driver\Provider;
use HomeCalculator\Driver\Service;
use HomeCalculator\Logger\Log;
use HomeCalculator\Storage\Storage;
use Monolog\Level;

final class GorskyProvider extends Provider
{

    public function __construct(string $url)
    {
        $this->organizationName = 'ООО "КЖЭК Горский"';
        $this->url = $url;
        $this->storage = Storage::getInstance();
        $this->actualizeServicesTaxes();
        $keys = array_keys($this->getKeySelectorPairs());
        $this->services = [
            new Service(
                $keys[0],
                'Текущее содержание',
                (float)'32.23',
                "За метр квадратный"
            ),
            new Service(
                $keys[1],
                'Текущий ремонт',
                (float)'3',
                "За метр квадратный"
            )
        ];
        Log::create(self::class . ' constructor called', Level::Info);
    }

    public function getKeySelectorPairs(): array
    {
        $parent = 'body > main > div > div > div.div-flex > div.subpage > div > details:nth-child(2) > div > div > div.table-tariff__body > div:nth-child(1)';

        return [
            $this->generateServiceKey('1') => "$parent > div:nth-child(2)",
            $this->generateServiceKey('2') => "$parent > div:nth-child(3)",
        ];
    }
}