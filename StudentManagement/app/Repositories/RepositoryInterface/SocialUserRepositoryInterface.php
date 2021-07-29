<?php

namespace App\Repositories\RepositoryInterface;

interface SocialUserRepositoryInterface
{
    public function checkProvider($type, $email);
}
