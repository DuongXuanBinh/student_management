<?php
namespace App\Repositories\RepositoryInterface;

interface UserRepositoryInterface
{
    public function checkProvider($type, $email);

    public function deleteUser($student_id);
}
