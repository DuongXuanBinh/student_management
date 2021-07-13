<?php
namespace App\Repositories\RepositoryInterface;

use App\Models\User;

interface UserRepositoryInterface
{
    public function checkSNS($type, $email);
}
