<?php

declare(strict_types=1);

namespace HomeCalculator\Driver;

use simplehtmldom\HtmlWeb;

final class Parser extends HtmlWeb
{
    private static ?HtmlWeb $parser;

    final public function __construct()
    {
    }

    public static function getInstance(): HtmlWeb
    {
        return self::$parser ??= new HtmlWeb();
    }
}