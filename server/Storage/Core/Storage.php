<?php

declare(strict_types=1);

namespace HomeCalculator\Storage\Core;

abstract class Storage implements StorageInterface
{
    protected function __construct(protected readonly string $storagePath)
    {
    }

    final public static function getInstance(): StorageInterface
    {
        static $instance;
        return $instance ??= new static(__DIR__ . '/../../../db/' . static::key() . '.json');
    }

    final public function read(string $key, string $nestedKey): string|float|null
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
    final public function write(string $key, array $data): void
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