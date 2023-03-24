<?php

declare(strict_types=1);

namespace App\Containers;

use Yiisoft\Di\Container;
use Yiisoft\Di\ContainerConfig;
use Yiisoft\Factory\Factory;

final class Yii implements ContainerInterface
{
    private Container $container;
    private ContainerConfig $config;
    private Factory $factory;

    public function __construct()
    {
        $this->config = ContainerConfig::create()
            ->withValidate(false);
    }

    public function bind(string $id, $definition): void
    {
        $this->config = $this->config->withDefinitions([
            $id => [
                'definition' => $definition,
            ],
        ]);
    }

    public function make(string $id): mixed
    {
        return $this->factory->create($id);
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
        $this->container = new Container($this->config);
        $this->factory = new Factory($this->container);
    }
}