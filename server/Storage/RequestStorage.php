<?php

declare(strict_types=1);

namespace HomeCalculator\Storage;

/**
 * @method static RequestStorage getInstance()
 */
final class RequestStorage extends Storage
{
    public static function key(): string
    {
        return 'request';
    }
}