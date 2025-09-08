<?php

declare(strict_types=1);

namespace HomeCalculator;

final class App
{
    private string $name;

    private static self $instance;

    private function __construct()
    {
        $this->name = "Home calculator";
    }

    public static function init(): self
    {
        return self::$instance ??= new self();
    }

    public function getName(): string
    {
        return $this->name;
    }
}