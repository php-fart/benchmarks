<?php

namespace App\User\Valinor;

class Profile
{
    public function __construct(
        public string $firstName = '',
        public string $lastName = '',
        public string $phone = '',
        public Address $address,
        /** @var SocialAccount[] */
        public array $accounts,
    ) {
    }
}

