<?php

declare(strict_types=1);

namespace App\Containers;

final class TestClass
{
    public function __construct(
        private readonly SampleClass $sampleClass,
        private readonly string $foo = 'bar',
    ) {
    }
}