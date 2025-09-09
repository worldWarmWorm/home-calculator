<?php

namespace HomeCalculator\Provider;

interface ProviderInterface
{
    public const string NAME = 'name';

    public const string TAX = 'tax';

    public const string MEASURE = 'measure';

    public function parseInfo(string $url, array $props): array;
}