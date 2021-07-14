<?php
namespace App\Repositories\RepositoryInterface;

interface UserRepositoryInterface
{
    public function checkProvider($type, $email);
}
