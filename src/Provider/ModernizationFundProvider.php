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
    /**
     * @throws DateInvalidTimeZoneException | DateMalformedStringException
     */
    public function __construct(string $url)
    {
        $this->organizationName = 'Фонд модернизации ЖКХ';
        $this->url = $url;
        $this->storage = Storage::getInstance();
        $this->actualizeServicesTaxes($this);
        $this->services = [
            new Service(
                self::generateServiceKey('1'),
                'Взнос за капитальный ремонт',
                $this->storage->read($this->organizationName, self::generateServiceKey('1')),
                'за 1 кв.м площади квартиры'
            )
        ];
        Log::create(self::class . ' constructor called', Level::Info);
    }

    /**
     * @inheritDoc
     */
    public function actualizeServicesTaxes(ProviderInterface $provider): void
    {
        if (false === $this->isTimeToUpdateServicesTaxes(TimezoneEnum::NOVOSIBIRSK->value)) {
            return;
        }

        $taxes = $this->parseTaxesByServiceKeys([
            $this->generateServiceKey('1'),
        ]);

        foreach ($taxes as $serviceKey => $tax) {
            $this->storage->write($this->organizationName, [$serviceKey => $tax]);
        }
    }

    public function parseTaxesByServiceKeys(array $serviceKeys): array
    {
        $parser = new Parser();
        $callbacks = [];

        foreach ($serviceKeys as $serviceKey) {
            $callbacks[$serviceKey] = match ($serviceKey) {
                $this->generateServiceKey('1') => fn(): float => $parser->parseTax($this->url, 'body > div.wrap.container-fluid > div > main > section > div.col-lg-8 > div.row > div.col-xs-9 > ul:nth-child(3) > li:nth-child(3)'),
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