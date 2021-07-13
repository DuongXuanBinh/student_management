<?php

namespace App\Http\Controllers;

use App\Repositories\RepositoryInterface\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    protected $_userRepository;
    public function __constructor(UserRepositoryInterface $userRepository)
    {
        $this->_userRepository=$userRepository;
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
        $user = $this->_userRepository->checkSNS($provider,$info->email);
        if(!$user){
            $user = User::create([
                'email' => $info->email,
                'sns_type' => $provider
            ]);
        }

        return $user;
    }
}
