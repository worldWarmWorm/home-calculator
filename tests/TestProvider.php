<?php

declare(strict_types=1);

namespace HomeCalculator\Tests;

use DateTimeImmutable;
use DateTimeZone;
use HomeCalculator\Storage\Storage;
use PHPUnit\Framework\TestCase;

final class TestProvider extends TestCase
{
    public function testA(): void
    {


        $storage = Storage::getInstance();
    }
}