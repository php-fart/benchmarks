<?php

declare(strict_types=1);

namespace App\Serializers;

final class IgBinary implements SerializerInterface
{
    private mixed $payload;
    private string $serialized;

    public function getName(): string
    {
        return 'Ig Binary';
    }

    public function init(mixed $payload): void
    {
        $this->payload = $payload;
        $this->serialized = $this->serialize();
    }

    public function serialize(): string
    {
        return \igbinary_serialize($this->payload);
    }

    public function deserialize(): mixed
    {
        return \igbinary_unserialize($this->serialized);
    }
}