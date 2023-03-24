<?php

declare(strict_types=1);

namespace App\Containers;

final class SampleClass
{
    public function __construct(
        private readonly TestClass1 $testClass,
    ) {
    }
}