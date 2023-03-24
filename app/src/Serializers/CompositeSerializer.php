<?php

declare(strict_types=1);

namespace App\Serializers;

final class CompositeSerializer
{
    private array $serializers;

    public function addSerializer(SerializerInterface $serializer, mixed $payload, ?string $type = null): void
    {
        $payloadType = $type ?? \gettype($payload);
        $this->serializers[$serializer->getName() . ' ' . $payloadType] = $serializer;
        $serializer->init($payload);
    }

    public function getSerializers(): array
    {
        return $this->serializers;
    }

    public function getPayloadSize(): array
    {
        $result = [];

        foreach ($this->serializers as $name => $serializer) {
            $result[$name] = \strlen($serializer->serialize());
        }

        return $result;
    }
}