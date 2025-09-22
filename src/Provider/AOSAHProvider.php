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
        $this->services = [
            new Service(
                self::generateServiceKey('1'),
                'Обращение с ТКО',
                $this->storage->read($this->organizationName, self::generateServiceKey('1')),
                'с одного человека, прописанного в квартире'
            )
        ];
        Log::create(self::class . ' constructor called', Level::Info);
    }

    /**
     * @inheritDoc
     */
    public function actualizeServicesTaxes(): void
    {
        if (false === $this->isTimeToUpdateServicesTaxes(TimezoneEnum::NOVOSIBIRSK->value)) {
            return;
        }

        $taxes = $this->parseTaxesByServiceKeys([$this->generateServiceKey('1')]);

        foreach ($taxes as $serviceKey => $tax) {
            $this->storage->write($this->organizationName, [$serviceKey => $tax]);
        }
    }

    public function parseTaxesByServiceKeys(array $serviceKeys): array
    {
        $parser = Parser::getInstance();
        $html = $parser->load($this->url);
        $callbacks = [];

        foreach ($serviceKeys as $serviceKey) {
            $callbacks[$serviceKey] = match ($serviceKey) {
                $this->generateServiceKey('1') => static function () use ($html): float {
                    preg_match(
                        '/\d+,\d+/',
                        $html->find('body div.body div.main div.container div.tariffs-page div.styled-block ul li strong', 8)->plaintext,
                        $matches
                    );
                    return isset($matches[0]) ? (float)str_replace(',', '.', $matches[0]) : 0;
                },
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