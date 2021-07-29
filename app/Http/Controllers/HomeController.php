<?php

namespace App\Http\Controllers;

use App\Repositories\RepositoryInterface\StudentRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $_studentRepository;

    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->_studentRepository = $studentRepository;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     */
    public function index()
    {
        $user = Auth::user();

        $check = $this->_studentRepository->checkUserByMail($user->email);
        if (!$user->hasAnyRole('student', 'admin', 'non-registered')) {
            if ($check) {
                $user->assignRole('student');
            } else {
                $user->assignRole('non-registered');
            }
        } else {
            if ($user->hasRole('admin')) {
                return redirect()->route('students.index');
            } elseif ($user->hasRole('student')) {
                return redirect()->route('user.index');
            }
        }
        return view('home');
    }
}
