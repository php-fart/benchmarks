<?php

declare(strict_types=1);

namespace App\Endpoint\Console;

use App\User\DTO\Address;
use App\User\DTO\Profile;
use App\User\DTO\Role;
use App\User\DTO\SocialAccount;
use App\User\DTO\User;
use Spiral\Console\Attribute\AsCommand;
use Spiral\Console\Command;
use App\User\Valinor\User as UserDTO;
use CuyZ\Valinor\Mapper\Source\Source;
use DragonCode\Benchmark\Benchmark;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[AsCommand(
    name: 'bench:protobuf',
    description: 'Run protobuf vs json benchmarks',
)]
final class ProtobufBenchCommand extends Command
{
    private const USER_DATA = [
        'id' => 1,
        'username' => 'john',
        'email' => 'john@site.com',
        'roles' => [
            [
                'id' => 1,
                'name' => 'admin',
            ],
            [
                'id' => 1,
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

    private const ITERATIONS = 10_000;

    public function perform(): void
    {
        $user = new User([
            'id' => 1,
            'username' => 'john',
            'email' => 'john@site.com',
            'roles' => [
                new Role([
                    'id' => 1,
                    'name' => 'admin',
                ]),
                new Role([
                    'id' => 2,
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

        $mapper = (new \CuyZ\Valinor\MapperBuilder())->mapper();
        $userDTO = $mapper->map(UserDTO::class, Source::array(self::USER_DATA));


        $serializer = (new Serializer([new ObjectNormalizer()], [new JsonEncoder()]));

        (new Benchmark())
            ->iterations(self::ITERATIONS)
            ->withoutData()
            ->compare([
                'protobuf_encode' => $protoc = static fn () => $user->serializeToString(),
                'json_encode' => $json = static fn () => \json_encode(self::USER_DATA),
                'json_encode_from_object' => static fn () => \json_encode($userDTO),
                'symfony_encode' => static fn () => $serializer->serialize($userDTO, 'json'),
                'igbinary_encode' => $ig = static fn () => \igbinary_serialize($userDTO),
                'serialize' => $s = static fn () => \serialize(self::USER_DATA),
            ]);

        $protocString = $protoc();
        $jsonString = $json();
        $igString = $ig();
        $sString = $s();

        (new Benchmark())
            ->iterations(self::ITERATIONS)
            ->withoutData()
            ->compare([
                'protobuf_decode' => static fn () => (new User())->mergeFromString($protocString),
                'json_decode' => static fn () => \json_decode($jsonString),
                'symfony_decode' => static fn () => $serializer->deserialize($jsonString, UserDTO::class, 'json'),
                'valinor_decode' => static fn () => $mapper->map(UserDTO::class, Source::json($jsonString)),
                'valinor_decode_array' => static fn () => $mapper->map(UserDTO::class, Source::array(self::USER_DATA)),
                'igbinary_decode' => static fn () => \igbinary_unserialize($igString),
                'unserialize' => static fn () => \unserialize($sString),
            ]);

        $this->writeln(\sprintf('Protobuf size: %d bytes', \strlen($protocString)));
        $this->writeln(\sprintf('JSON size: %d bytes', \strlen($jsonString)));
        $this->writeln(\sprintf('IG size: %d bytes', \strlen($igString)));
        $this->writeln(\sprintf('Serializer size: %d bytes', \strlen($sString)));
    }
}