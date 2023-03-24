<?php

declare(strict_types=1);

namespace App\Containers;

final class CompositeContainer
{
    /** @var ContainerInterface[] */
    private array $containers = [];

    public function addContainer(ContainerInterface $container): void
    {
        $this->containers[$container::class] = $container;
    }

    public function init(): void
    {
        foreach ($this->containers as $container) {
            $container->init();
        }
    }

    public function getAll(string $id): array
    {
        $result = [];

        foreach ($this->containers as $container) {
            $result[$container::class] = \spl_object_id($container->get($id));
        }

        return $result;
    }

    public function makeAll(string $id): array
    {
        $result = [];

        foreach ($this->containers as $container) {
            $result[$container::class] = \spl_object_id($container->make($id));
        }

        return $result;
    }

    public function get(string $container, string $id): mixed
    {
        return $this->containers[$container]->get($id);
    }

    public function make(string $container, string $id): mixed
    {
        return $this->containers[$container]->make($id);
    }

    public function has(string $container, string $id): bool
    {
        return $this->containers[$container]->has($id);
    }

    public function bind(string $id, $definition): void
    {
        foreach ($this->containers as $container) {
            $container->bind($id, $definition);
        }
    }
}