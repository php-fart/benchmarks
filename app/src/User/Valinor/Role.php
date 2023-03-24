<?php

namespace App\User\Valinor;

class Role
{
    public function __construct(
        public int $id = 0,
        public string $name = '',
    ) {
    }
}

