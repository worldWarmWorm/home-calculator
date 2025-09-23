<?php

declare(strict_types=1);

namespace HomeCalculator\Driver;

use Symfony\Component\BrowserKit\CookieJar;
use Symfony\Component\BrowserKit\History;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class Parser extends HttpBrowser
{
    public function __construct(?HttpClientInterface $client = null, ?History $history = null, ?CookieJar $cookieJar = null)
    {
        parent::__construct($client, $history, $cookieJar);
    }

    public function parseTax(string $url, string $selector): float
    {
        return $this->extractTax($this->request('GET', $url)->filter($selector)->innerText());
    }

    private function extractTax(string $text): float
    {
        preg_match(
            '/\d+,\d+/',
            $text,
            $matches
        );
        return isset($matches[0]) ? (float)str_replace(',', '.', $matches[0]) : 0;
    }
}