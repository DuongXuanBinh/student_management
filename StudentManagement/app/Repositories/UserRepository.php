<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface\UserRepositoryInterface;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function update($id, array $attribute)
    {
        unset($attribute['id']);
        $result = $this->findByID($id);
        if ($result) {
            $result->update($attribute);

            return true;
        }

        return false;
    }

    public function checkProvider($type, $email)
    {
        $user = $this->_model->where('provider', $type)->where('email', $email)->first();
        if ($user === null) {
            $user = false;
        }
        return $user;
    }

    public function deleteUser($student_id)
    {
        if (is_array($student_id)) {
            $result = $this->_model->whereIn('student_id', $student_id);
        } else {
            $result = $this->_model->where('student_id', $student_id);
        }
        return $result->delete();
    }
}
