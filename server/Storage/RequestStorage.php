<?php

declare(strict_types=1);

namespace HomeCalculator\Storage;

use HomeCalculator\Storage\Storage;

class RequestStorage extends Storage
{

    public function read(string $key, string $nestedKey): string|float|null
    {
        // TODO: Implement read() method.
    }

    public function write(string $key, array $data): void
    {
        // TODO: Implement write() method.
    }
}