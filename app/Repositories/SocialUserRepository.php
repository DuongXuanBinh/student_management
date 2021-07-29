<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface\SocialUserRepositoryInterface;

class SocialUserRepository extends EloquentRepository implements SocialUserRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\SocialUser::class;
    }

    public function checkProvider($type, $email)
    {
        $user = $this->_model->where('provider', $type)->where('email', $email)->first();
        if (!$user) {
            return false;
        }
        return true;
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
