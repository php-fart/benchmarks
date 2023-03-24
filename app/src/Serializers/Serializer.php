<?php

declare(strict_types=1);

namespace App\Serializers;

final class Serializer implements SerializerInterface
{
    private mixed $payload;
    private string $serialized;

    public function getName(): string
    {
        return 'Native serializer';
    }

    public function init(mixed $payload): void
    {
        $this->payload = $payload;
        $this->serialized = $this->serialize();
    }

    public function serialize(): string
    {
        return \serialize($this->payload);
    }

    public function deserialize(): mixed
    {
        return \unserialize($this->serialized);
    }
}