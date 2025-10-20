<?php

declare(strict_types=1);

namespace HomeCalculator\Storage;

abstract class Storage implements StorageInterface
{
    protected static ?StorageInterface $instance = null;

    protected function __construct(protected readonly string $storagePath)
    {
    }

    final public static function getInstance(): StorageInterface
    {
        return static::$instance ??= new static(__DIR__ . '/../../db/' . static::key() . '.json');
    }

    final protected function asArray(): array
    {
        $storage = file_get_contents($this->storagePath);

        if (false === $storage) {
            return [];
        }

        return json_decode($storage, true);
    }
}