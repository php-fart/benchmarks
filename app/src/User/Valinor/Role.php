<?php

namespace App\User\Valinor;

class Role
{
    public function __construct(
        protected int $id = 0,
        protected string $name = '',
    ) {
    }
}

