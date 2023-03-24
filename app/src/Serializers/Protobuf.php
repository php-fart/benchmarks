<?php

declare(strict_types=1);

namespace App\Serializers;

use Google\Protobuf\Internal\Message;

final class Protobuf implements SerializerInterface
{
    private Message $payload;
    private string $serialized;

    public function getName(): string
    {
        return 'Protobuf';
    }

    public function init(mixed $payload): void
    {
        $this->payload = $payload;
        $this->serialized = $this->serialize();
    }

    public function serialize(): string
    {
        return $this->payload->serializeToString();
    }

    public function deserialize(): mixed
    {
        $class = $this->payload::class;
        return (new $class)->mergeFromString($this->serialized);
    }
}