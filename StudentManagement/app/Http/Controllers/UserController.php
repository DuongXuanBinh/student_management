<?php

namespace App\Http\Controllers;


use App\Repositories\Repository_Interface\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class UserController extends Controller
{
    protected $_userController;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        return $this->_userController = $userRepository;
    }

    public function createUser(Request $request, $id)
    {
        $details['student_id'] = $id;
        $details['email'] = $request->email;
        $details['password'] = Str::random(10);

        $user = $this->_userController->createUser($details);
        return $user;
    }
}
