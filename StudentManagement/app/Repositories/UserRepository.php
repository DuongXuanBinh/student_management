<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface\UserRepositoryInterface;
use Carbon\Carbon;

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
            $result['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh');
            $result->update($attribute);

            return true;
        }

        return false;
    }

    public function delete($user_id)
    {
        if(!is_array($user_id)) {
            $result = $this->_model->where('id', $user_id);
        }else {
            $result = $this->_model->whereIn('id', $user_id);
        }
        return $result->delete();
    }

    public function getByMail($email)
    {
        return $this->_model->where('email',$email)->first();
    }
}
