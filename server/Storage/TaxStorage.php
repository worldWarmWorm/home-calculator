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

    public function read(string $key, string $nestedKey): string|float|null
    {
        $storage = $this->asArray();

        if (
            [] === $storage
            || !isset($storage[$key], $storage[$key][$nestedKey])
        ) {
            return null;
        }

        return $storage[$key][$nestedKey];
    }

    /**
     * @param array<string, float|string> $data
     */
    public function write(string $key, array $data): void
    {
        $storage = $this->asArray();

        foreach ($data as $dataKey => $value) {
            $storage[$key][$dataKey] = $value;
        }

        file_put_contents($this->storagePath, json_encode($storage, JSON_PRETTY_PRINT));
    }
}