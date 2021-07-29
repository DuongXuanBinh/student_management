<?php
namespace App\Repositories\RepositoryInterface;

interface UserRepositoryInterface
{
    public function delete($user_id);

    public function getByMail($mail);
}
