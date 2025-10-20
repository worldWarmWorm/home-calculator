<?php

declare(strict_types=1);

namespace HomeCalculator\Storage;

final class TaxStorage extends Storage
{
    private const string PATH = __DIR__ . '/../../tax.db.json';

    private static ?TaxStorage $instance = null;

    private function __construct(private readonly string $storagePath)
    {
    }

    public static function getInstance(): self
    {
        return self::$instance ??= new self(self::PATH);
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

    private function asArray(): array
    {
        $storage = file_get_contents($this->storagePath);

        if (false === $storage) {
            return [];
        }

        return json_decode($storage, true);
    }
}