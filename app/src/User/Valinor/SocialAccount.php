<?php

namespace App\User\Valinor;

class SocialAccount
{
    public function __construct(
        public string $name,
        public string $url,
    ) {
    }
}

