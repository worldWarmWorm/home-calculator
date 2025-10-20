<?php

namespace HomeCalculator\Storage;

interface StorageInterface
{
    public static function key(): string;

    public function read(string $key, string $nestedKey): string|float|null;

    public function write(string $key, array $data): void;
}