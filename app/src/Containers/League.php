<?php

declare(strict_types=1);

namespace App\Containers;

use League\Container\Container;
use League\Container\ReflectionContainer;

final class League implements ContainerInterface
{
    private Container $container;

    public function __construct()
    {
        $this->container = new Container();
    }

    public function make(string $id): mixed
    {
        return $this->container->getNew($id);
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
        $this->container->addShared($id, $definition);
    }

    public function init(): void
    {
        $this->container->delegate(new ReflectionContainer());
    }
}