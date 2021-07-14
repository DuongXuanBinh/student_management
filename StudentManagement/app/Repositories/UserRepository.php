<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface\UserRepositoryInterface;

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

    public function checkProvider($type, $email)
    {
        $user = $this->_model->where('provider', $type)->where('email',$email)->first();
        if ($user === null) {
            $user = false;

            return $user;
        }
        return $user;
    }

}
