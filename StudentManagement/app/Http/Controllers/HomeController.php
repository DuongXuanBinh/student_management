<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     */
    public function index()
    {
        $user = Auth::user();
//        $user->assignRole('admin');
        if ($user->hasRole('admin')) {
            return redirect('/students');
        }
        $user->assignRole('student');
        return redirect('/user/');

    }
}
