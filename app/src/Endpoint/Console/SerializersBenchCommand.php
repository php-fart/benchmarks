<?php

declare(strict_types=1);

namespace App\Endpoint\Console;

use App\Serializers\{CompositeSerializer, IgBinary, Json, Protobuf, SerializableClosure, Serializer, Symfony, Valinor};
use App\User\DTO\{Address, Profile, Role, SocialAccount, User};
use Spiral\Console\Attribute\{AsCommand, Option};
use Spiral\Console\Command;
use App\User\Valinor\User as UserDTO;
use CuyZ\Valinor\Mapper\Source\Source;
use DragonCode\Benchmark\Benchmark;

#[AsCommand(
    name: 'bench:serializers',
    description: 'Run serializers benchmarks (protobuf vs json vs igbinary vs serialize vs symfony)',
)]
final class SerializersBenchCommand extends Command
{
    #[Option(shortcut: 'i', description: 'Iterations count')]
    private int $iterations = 1_000;

    public function perform(): void
    {
        [$userMessage, $userDTO, $userArray] = $this->initData();

        $serializers = new CompositeSerializer();
        $serializers->addSerializer(new Json(), $userArray);
        $serializers->addSerializer(new Json(), $userDTO);

        $serializers->addSerializer(new IgBinary(), $userArray);
        $serializers->addSerializer(new IgBinary(), $userDTO);

        $serializers->addSerializer(new Serializer(), $userArray);
        $serializers->addSerializer(new Serializer(), $userDTO);

        $serializers->addSerializer(new Protobuf(), $userMessage);

        $serializers->addSerializer(new Symfony(), $userArray);
        $serializers->addSerializer(new Symfony(), $userDTO);

        $serializers->addSerializer(new Valinor(), $userArray);

        $serializers->addSerializer(new SerializableClosure(), $userArray);
        $serializers->addSerializer(new SerializableClosure(), $userDTO);

        $serializers->addSerializer(new SerializableClosure(true), $userArray, 'array w/secret');
        $serializers->addSerializer(new SerializableClosure(true), $userDTO, 'object w/secret');

        $encodeTests = [];
        $decodeTests = [];

        foreach ($serializers->getSerializers() as $name => $serializer) {
            $encodeTests[$name] = static fn () => $serializer->serialize();
            $decodeTests[$name] = static fn () => $serializer->deserialize();
        }

        $this->info('Data Encoding');
        (new Benchmark())->iterations($this->iterations)->withoutData()->round(5)->compare($encodeTests);

        $this->info('Data Decoding');
        (new Benchmark())->iterations($this->iterations)->withoutData()->round(5)->compare($decodeTests);

        $this->info('Data Size in Bytes');
        foreach ($serializers->getSerializers() as $name => $serializer) {
            $names[$name] = (string)\strlen($serializer->serialize());
        }
        $this->table(\array_keys($names))->addRow(\array_values($names))->render();
    }

    /**
     * @return array
     * @throws \CuyZ\Valinor\Mapper\MappingError
     */
    public function initData(): array
    {
        $id = \PHP_INT_MAX;
        $user = new User([
            'id' => $id,
            'username' => 'john',
            'email' => 'john@site.com',
            'roles' => [
                new Role([
                    'id' => $id,
                    'name' => 'admin',
                ]),
                new Role([
                    'id' => $id,
                    'name' => 'user',
                ]),
            ],
            'profile' => new Profile([
                'firstName' => 'John',
                'lastName' => 'Doe',
                'phone' => '+1234567890',
                'address' => new Address([
                    'street' => 'Street',
                    'city' => 'City',
                    'state' => 'State',
                    'zip' => '12345',
                ]),
                'accounts' => [
                    new SocialAccount([
                        'name' => 'Github',
                        'url' => 'https://site.com/account1',
                    ]),
                    new SocialAccount([
                        'name' => 'LinkedIn',
                        'url' => 'https://site.com/account2',
                    ]),
                ],
            ]),
        ]);

        $userArray = [
            'id' => $id,
            'username' => 'john',
            'email' => 'john@site.com',
            'roles' => [
                [
                    'id' => $id,
                    'name' => 'admin',
                ],
                [
                    'id' => $id,
                    'name' => 'user',
                ],
            ],
            'profile' => [
                'firstName' => 'John',
                'lastName' => 'Doe',
                'phone' => '+1234567890',
                'address' => [
                    'street' => 'Street',
                    'city' => 'City',
                    'state' => 'State',
                    'zip' => '12345',
                ],
                'accounts' => [
                    [
                        'name' => 'Github',
                        'url' => 'https://site.com/account1',
                    ],
                    [
                        'name' => 'LinkedIn',
                        'url' => 'https://site.com/account2',
                    ],
                ],
            ],
        ];

        $mapper = (new \CuyZ\Valinor\MapperBuilder())->mapper();
        $userDTO = $mapper->map(UserDTO::class, Source::array($userArray));


        return [$user, $userDTO, $userArray];
    }
}