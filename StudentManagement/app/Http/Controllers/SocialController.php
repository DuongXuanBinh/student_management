<?php

namespace App\Http\Controllers;

use App\Repositories\RepositoryInterface\StudentRepositoryInterface;
use App\Repositories\RepositoryInterface\UserRepositoryInterface;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    protected $_userRepository;
    protected $_studentRepository;

    public function __constructor(UserRepositoryInterface $userRepository,
                                  StudentRepositoryInterface $studentRepository)
    {
        $this->_userRepository = $userRepository;
        $this->_studentRepository = $studentRepository;
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $info = Socialite::driver($provider)->user();
        $user = $this->createUser($info, $provider);
        auth()->login($user);

        return redirect('/home');
    }

    public function createUser($info, $provider)
    {
        $user = $this->_userRepository->checkSNS($provider, $info->email);
        $student_id = $this->_studentRepository->getIDByMail($info->email);
        if (!$user) {
            $user = User::create([
                'student_id' => $student_id,
                'email' => $info->email,
                'sns_type' => $provider
            ]);
        }

        return $user;
    }
}
