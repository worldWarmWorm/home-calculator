<?php

declare(strict_types=1);

namespace HomeCalculator\Provider;

use HomeCalculator\Driver\Parser;
use HomeCalculator\Driver\Provider;
use HomeCalculator\Driver\Service;
use HomeCalculator\Storage\Storage;

final class AOSAHProvider extends Provider
{
    public function __construct(string $url)
    {
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
        $storage = Storage::getInstance();
        $tax = $storage->read($this->organizationName, $serviceKey);

        if (null === $tax) {
            $parser = Parser::getInstance();
            $html = $parser->load($this->url);

            preg_match(
                '/\d+,\d+/',
                $html->find('body div.body div.main div.container div.tariffs-page div.styled-block ul li strong', 8)->plaintext,
                $matches
            );

            $tax = isset($matches[0]) ? (float)str_replace(',', '.', $matches[0]) : 0;
            $storage->write($this->organizationName, [$serviceKey => $tax]);

            return $tax;
        }

        return $tax;
    }
}