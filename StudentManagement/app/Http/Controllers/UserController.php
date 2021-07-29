<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Http\Requests\UserRequest;
use App\Repositories\RepositoryInterface\DepartmentRepositoryInterface;
use App\Repositories\RepositoryInterface\StudentRepositoryInterface;
use App\Repositories\RepositoryInterface\SubjectRepositoryInterface;
use App\Repositories\RepositoryInterface\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $_userRepository;
    protected $_studentRepository;
    protected $_departmentRepository;
    protected $_subjectRepository;

    public function __construct(UserRepositoryInterface $userRepository,
                                StudentRepositoryInterface $studentRepository,
                                DepartmentRepositoryInterface $departmentRepository,
                                SubjectRepositoryInterface $subjectRepository)
    {
        $this->_userRepository = $userRepository;
        $this->_studentRepository = $studentRepository;
        $this->_departmentRepository = $departmentRepository;
        $this->_subjectRepository = $subjectRepository;
    }

    public function index()
    {
        $email = Auth::user()->email;
        $id = $this->_studentRepository->getIDByMail($email);
        $user = $this->_studentRepository->findByID($id);

        return response()->view('users.index', compact('user'));
    }

    public function edit()
    {
        $email = Auth::user()->email;
        $id = $this->_studentRepository->getIDByMail($email);
        $user = $this->_studentRepository->findByID($id);
        $departments = $this->_departmentRepository->getAll();

        return response()->view('users.edit', compact('departments', 'user'));
    }

    public function update(StudentRequest $request, $id)
    {
        $array['email'] = $request->email;
        $this->_userRepository->update($request->user_id,$array);
        $this->_studentRepository->update($id, $request->all());

        return redirect('/user')->with('notification', 'Update Successfully');
    }

    public function create(UserRequest $request)
    {
        $details['email'] = $request->email;
        $details['password'] = Str::random(10);
        $user = $this->_userRepository->create($details);

        return $user;
    }

    public function getResult()
    {
        $email = Auth::user()->email;
        $id = $this->_studentRepository->getIDByMail($email);
        $results = $this->_studentRepository->getResultByStudentID($id);
        $gpa = $this->_studentRepository->getGPA($id);
        $user = $this->_studentRepository->findByID($id);
        $enrollable_subjects = $this->_subjectRepository->getEnrollableSubject($user->department_id, $results->pluck('name')->toArray());

        return view('users.user_result', compact('results', 'gpa', 'user', 'enrollable_subjects'));
    }

    public function enroll(Request $request)
    {
        $this->_studentRepository->enrollSubject($request->all());

        return back()->with('notification', 'Enroll Successfully');
    }

    public function changeLanguage($language)
    {
        Session::put('website_language', $language);

        return redirect()->back();
    }

}
