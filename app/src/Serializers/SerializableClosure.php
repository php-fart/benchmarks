<?php

declare(strict_types=1);

namespace App\Serializers;

use Laravel\SerializableClosure\Serializers\Signed;

final class SerializableClosure implements SerializerInterface
{
    private mixed $payload;
    private string $serialized;

    public function __construct(private readonly bool $hashPayload = false)
    {
    }

    public function getName(): string
    {
        return 'SerializableClosure';
    }

    public function init(mixed $payload): void
    {
        if ($this->hashPayload) {
            \Laravel\SerializableClosure\SerializableClosure::setSecretKey('secret');
        }

        $this->payload = new \Laravel\SerializableClosure\SerializableClosure(fn () => $payload);
        $this->serialized = $this->serialize();
    }

    public function serialize(): string
    {
        return \serialize($this->payload);
    }

    public function deserialize(): mixed
    {
        if (!$this->hashPayload && Signed::$signer !== null) {
            \Laravel\SerializableClosure\SerializableClosure::setSecretKey(null);
        } elseif ($this->hashPayload && Signed::$signer === null) {
            \Laravel\SerializableClosure\SerializableClosure::setSecretKey('secret');
        }

        return \unserialize($this->serialized);
    }
}