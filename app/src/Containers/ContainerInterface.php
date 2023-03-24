<?php

declare(strict_types=1);

namespace App\Containers;

interface ContainerInterface extends \Psr\Container\ContainerInterface
{
    public function bind(string $id, $definition): void;

    public function make(string $id): mixed;

    public function init(): void;
}