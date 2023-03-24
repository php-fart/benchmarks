<?php

namespace App\User\Valinor;

class Address
{
    public function __construct(
        public string $street,
        public string $city,
        public string $state,
        public string $zip,
    ) {
    }
}

