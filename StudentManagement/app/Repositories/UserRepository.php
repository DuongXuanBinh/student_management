<?php

namespace App\Repositories;

use App\Repositories\Repository_Interface\UserRepositoryInterface;
use Illuminate\Support\Facades\App;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function updateProfile()
    {
        // TODO: Implement updateProfile() method.
    }
}
