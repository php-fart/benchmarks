<?php

declare(strict_types=1);

namespace App\Serializers;

interface SerializerInterface
{
    public function getName(): string;

    public function init(mixed $payload): void;
    public function serialize(): string;
    public function deserialize(): mixed;
}