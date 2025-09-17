<?php

declare(strict_types=1);

namespace HomeCalculator\Storage;

final class Storage
{
    private const string PATH = __DIR__ . '/../../db.json';

    private static Storage $instance;

    private function __construct(private readonly string $storagePath)
    {
    }

    public static function getInstance(): self
    {
        return self::$instance ??= new self(self::PATH);
    }

    public function read(string $organizationName, string $serviceKey): string|float|null
    {
        $storage = $this->asArray();

        if (
            [] === $storage
            || !isset($storage[$organizationName], $storage[$organizationName][$serviceKey])
        ) {
            return null;
        }

        return $storage[$organizationName][$serviceKey];
    }

    /**
     * @param array<string, float|string> $data
     */
    public function write(string $organizationName, array $data): void
    {
        $storage = $this->asArray();

        foreach ($data as $serviceKey => $value) {
            $storage[$organizationName][$serviceKey] = $value;
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