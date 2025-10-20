<?php

declare(strict_types=1);

namespace HomeCalculator\Storage;

/**
 * @method static TaxStorage getInstance()
 */
final class TaxStorage extends Storage
{
    public static function key(): string
    {
        return 'tax';
    }
}