<?php

declare(strict_types=1);

namespace App\Serializers;

use App\User\Valinor\User as UserDTO;
use CuyZ\Valinor\Mapper\Source\Source;

final class Valinor implements SerializerInterface
{
    private mixed $payload;
    private string $serialized;
    private \CuyZ\Valinor\Mapper\TreeMapper $mapper;

    public function getName(): string
    {
        return 'Valinor';
    }

    public function init(mixed $payload): void
    {
        $this->payload = $payload;
        $this->serialized = $this->serialize();

        $this->mapper = (new \CuyZ\Valinor\MapperBuilder())->mapper();
    }

    public function serialize(): string
    {
        return \json_encode($this->payload, \JSON_THROW_ON_ERROR);
    }

    public function deserialize(): mixed
    {
        return $this->mapper->map(UserDTO::class, Source::json($this->serialized));
    }
}