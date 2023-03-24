<?php

declare(strict_types=1);

namespace App\Serializers;

use App\User\Valinor\User as UserDTO;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class Symfony implements SerializerInterface
{
    private mixed $payload;
    private string $serialized;
    private Serializer $serializer;

    public function getName(): string
    {
        return 'Symfony';
    }

    public function init(mixed $payload): void
    {
        $this->serializer = (new Serializer([new ObjectNormalizer()], [new JsonEncoder()]));

        $this->payload = $payload;
        $this->serialized = $this->serialize();
    }

    public function serialize(): string
    {
        return $this->serializer->serialize($this->payload, 'json');
    }

    public function deserialize(): mixed
    {
        return $this->serializer->deserialize($this->serialized, UserDTO::class, 'json');
    }
}