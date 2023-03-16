<?php

namespace App\User\Valinor;

class Profile
{
    protected string $firstName = '';
    protected string $lastName = '';
    protected string $phone = '';
    protected Address $address;
    /**
     * @var SocialAccount[]
     */
    protected array $accounts;
}

