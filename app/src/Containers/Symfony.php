<?php

declare(strict_types=1);

namespace App\Containers;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServiceConfigurator;

final class Symfony implements ContainerInterface
{
    private ContainerBuilder $builder;

    public function __construct()
    {
        $this->builder = new ContainerBuilder();
    }

    public function make(string $id): mixed
    {
        return $this->builder->get($id);
    }

    public function get(string $id)
    {
        return $this->builder->get($id);
    }

    public function has(string $id): bool
    {
        return $this->builder->has($id);
    }

    public function bind(string $id, $definition): void
    {
        $this->builder->set($id, $definition());
    }

    public function init(): void
    {
        $this->builder->autowire(TestClass::class)->setAutowired(true)->setPublic(true);
        $this->builder->autowire(TestClass1::class)->setAutowired(true)->setPublic(true);
        $this->builder->autowire(SampleClass::class)->setAutowired(true)->setPublic(true);
        $this->builder->compile();
    }
}