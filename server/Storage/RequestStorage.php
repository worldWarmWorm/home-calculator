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

    public function read(string $key, string $nestedKey): string|float|null
    {
        // TODO: Implement read() method.
    }

    public function write(string $key, array $data): void
    {
        // TODO: Implement write() method.
    }
}