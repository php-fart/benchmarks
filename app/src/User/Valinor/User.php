<?php

namespace App\User\Valinor;

class User
{
    public function __construct(
        public int $id,
        public string $username,
        public string $email,
        /**
         * @var Role[]
         */
        public array $roles,
        public Profile $profile,
    ) {
    }
}

