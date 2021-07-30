<?php

namespace App\Repositories\RepositoryInterface;

interface SocialUserRepositoryInterface
{
    public function checkProvider($type, $email);

    public function deleteUser($student_id);
}
