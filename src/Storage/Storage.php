<?php

declare(strict_types=1);

namespace HomeCalculator\Storage;

final class Storage
{
    private static Storage $instance;

    private function __construct(private readonly string $storagePath)
    {
    }

    public static function getInstance(): self
    {

        return self::$instance ??= new self('db.json');
    }

    public function read(string $organizationName, string $key): string
    {
        $storage = $this->asArray();

        if (!isset($storage[$organizationName])) {
            throw new StorageException("Organization name \"$organizationName\" does not exist");
        }

        if (!isset($storage[$organizationName][$key])) {
            throw new StorageException("Key \"$key\" in organization \"$organizationName\" does not exist");
        }

        return $storage[$organizationName][$key];
    }

    /**
     * @param array<string, float|string> $data
     */
    public function write(string $organizationName, array $data): void
    {
        $storage = $this->asArray();

        foreach ($data as $key => $value) {
            $storage[$organizationName][$key] = $value;
        }

        file_put_contents($this->storagePath, json_encode($storage));
    }

    private function asArray(): array
    {
        $storage = file_get_contents($this->storagePath);

        return json_decode($storage, true);
    }
}