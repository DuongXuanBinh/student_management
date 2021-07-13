<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface\UserRepositoryInterface;
use App\Models\User;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function createUser(array $attribute)
    {
        return parent::create($attribute);
    }

    public function checkSNS($type, $email)
    {
        $user = User::where('sns_type', $type)->where('email',$email)->first();
        if ($user === null) {
            $user = false;

            return $user;
        }
        return $user;
    }

}
