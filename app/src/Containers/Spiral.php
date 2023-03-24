<?php

declare(strict_types=1);

namespace App\Containers;

use Spiral\Core\Container;

final class Spiral implements ContainerInterface
{
    private Container $container;

    public function __construct()
    {
        $this->container = new Container();
    }

    public function make(string $id): mixed
    {
        return $this->container->make($id);
    }

    public function bind(string $id, $definition): void
    {
        $this->container->bindSingleton($id, $definition);
    }

    public function get(string $id)
    {
        return $this->container->get($id);
    }

    public function has(string $id): bool
    {
        return $this->container->has($id);
    }

    public function init(): void
    {
        // TODO: Implement init() method.
    }
}