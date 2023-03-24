<?php

declare(strict_types=1);

namespace App\Containers;

final class TestClass1
{
    public function __construct(
        private readonly string $foo = 'bar',
    ) {
    }
}