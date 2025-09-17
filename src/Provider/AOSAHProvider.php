<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use DateInvalidTimeZoneException;
use DateMalformedStringException;
use DateTimeImmutable;
use HomeCalculator\Driver\Parser;
use HomeCalculator\Driver\Provider;
use HomeCalculator\Driver\Service;
use HomeCalculator\Storage\Storage;

final class AOSAHProvider extends Provider
{
    /**
     * @throws DateMalformedStringException
     * @throws DateInvalidTimeZoneException
     */
    public function __construct(string $url)
    {
        $serviceKeys = [$this->generateServiceKey('1')];
        $parser = Parser::getInstance();

        foreach ($serviceKeys as $serviceKey) {
            if ($this->isTimeToUpdateTax()) {
                $html = $parser->load($this->url);

                preg_match(
                    '/\d+,\d+/',
                    $html->find('body div.body div.main div.container div.tariffs-page div.styled-block ul li strong', 8)->plaintext,
                    $matches
                );

                $tax = isset($matches[0]) ? (float)str_replace(',', '.', $matches[0]) : 0;
                $storage = Storage::getInstance();
                $storage->write($this->organizationName, [$serviceKey => $tax]);
            }
        }

        $this->organizationName = 'АО "САХ"';
        $this->url = $url;
    }

    #[\Override]
    public function loadCard(): array
    {
        return [
            'organizationName' => $this->organizationName,
            'url' => $this->url,
            'services' => [
                new Service(
                    'Обращение с ТКО',
                    $this->loadTax(self::generateServiceKey('1')),
                    'с одного человека, прописанного в квартире'
                )
            ]
        ];
    }

    private function loadTax(string $serviceKey): ?float
    {
        return Storage::getInstance()->read($this->organizationName, $serviceKey);
    }
}