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

    }

    public function createUser(array $attribute)
    {
        return parent::create($attribute);
    }

}
