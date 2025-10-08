<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use HomeCalculator\Driver\Multiplier;
use HomeCalculator\Driver\Provider;
use HomeCalculator\Driver\Service;
use HomeCalculator\Logger\Log;
use HomeCalculator\Storage\Storage;
use Monolog\Level;

final class AOSAHProvider extends Provider
{
    public function __construct(string $url)
    {
        $this->organizationName = 'АО "САХ"';
        $this->url = $url;
        $this->storage = Storage::getInstance();
        $this->actualizeServicesTaxes();
        $keys = array_keys($this->getKeySelectorPairs());
        $this->services = [
            new Service(
                $keys[0],
                'Обращение с ТКО',
                $this->storage->read($this->organizationName, $keys[0]),
                'чел',
                [
                    new Multiplier(
                        'Человек в квартире',
                        'humans-in-house',
                        'чел'
                    )
                ]
            )
        ];
        Log::create(self::class . ' constructor called', Level::Info);
    }

    public function getKeySelectorPairs(): array
    {
        return [
            $this->generateServiceKey('1') => 'body > div.body > div.main > div:nth-child(2) > div.tariffs-page > div:nth-child(1) > ul > li:nth-child(6) > strong:nth-child(2)',
        ];
    }
}