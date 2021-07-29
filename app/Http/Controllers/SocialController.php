<?php

namespace App\Http\Controllers;

use App\Repositories\RepositoryInterface\SocialUserRepositoryInterface;
use App\Repositories\RepositoryInterface\StudentRepositoryInterface;
use App\Repositories\RepositoryInterface\UserRepositoryInterface;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    protected $_userRepository;
    protected $_socialUserRepository;
    protected $_studentRepository;

    public function __construct(UserRepositoryInterface $userRepository,
                                SocialUserRepositoryInterface $socialUserRepository,
                                StudentRepositoryInterface $studentRepository)
    {
        $this->_userRepository = $userRepository;
        $this->_socialUserRepository = $socialUserRepository;
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

        return redirect()->route('user.index');
    }

    public function createUser($info, $provider)
    {
        $check = $this->_socialUserRepository->checkProvider($provider, $info->email);
        if (!$check) {
            $user_id = $this->_studentRepository->getIDByMail($info->email);
            $this->_socialUserRepository->create([
                'user_id' => $user_id,
                'email' => $info->email,
                'provider' => $provider,
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                'updated_at' => Carbon::now('Asia/Ho_Chi_Minh')
            ]);
        }
        $user = $this->_userRepository->getByMail($info->email);

        return $user;
    }
}
