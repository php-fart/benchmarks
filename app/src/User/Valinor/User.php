<?php

namespace App\User\Valinor;

class User
{
    public function __construct(
        protected int $id,
        protected string $username,
        protected string $email,
        /**
         * @var Role[]
         */
        protected array $roles,
        protected Profile $profile,
    ) {
    }
}

