<?php

declare(strict_types=1);

namespace App\Containers;

use DI\Container;
use DI\ContainerBuilder;

final class PhpDi implements ContainerInterface
{
    private Container $container;

    public function __construct()
    {
        $this->container = (new ContainerBuilder())
            ->build();
    }

    public function make(string $id): mixed
    {
        return $this->container->make($id);
    }

    public function get(string $id)
    {
        return $this->container->get($id);
    }

    public function has(string $id): bool
    {
        return $this->container->has($id);
    }

    public function bind(string $id, $definition): void
    {
        $this->container->set($id, $definition);
    }

    public function init(): void
    {
        // TODO: Implement init() method.
    }
}