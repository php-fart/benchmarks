<?php

declare(strict_types=1);

namespace App\Serializers;

final class Json implements SerializerInterface
{
    private mixed $payload;
    private string $serialized;

    public function getName(): string
    {
        return 'JSON';
    }

    public function init(mixed $payload): void
    {
        $this->payload = $payload;
        $this->serialized = $this->serialize();
    }

    public function serialize(): string
    {
        return \json_encode($this->payload);
    }

    public function deserialize(): mixed
    {
        return \json_decode($this->serialized, true);
    }
}