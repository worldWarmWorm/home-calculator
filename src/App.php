<?php

declare(strict_types=1);

namespace HomeCalculator;

use HomeCalculator\Driver\ProviderInterface;

final class App
{
    private readonly string $name;

    /**
     * @var array<int, ProviderInterface>
     */
    private array $providers;

    private static self $instance;

    private function __construct(array $providers)
    {
        $this->name = "Home calculator";
        $this->providers = $providers;
    }

    public static function init(array $providers): self
    {
        return self::$instance ??= new self($providers);
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array<int, ProviderInterface>
     */
    public function getProviders(): array
    {
        return $this->providers;
    }
}