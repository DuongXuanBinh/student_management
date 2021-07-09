<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Repositories\DepartmentRepository;
use App\Repositories\RepositoryInterface\DepartmentRepositoryInterface;
use App\Repositories\RepositoryInterface\ResultRepositoryInterface;
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
    protected $_resultRepository;
    protected $_subjectRepository;

    public function __construct(UserRepositoryInterface $userRepository,
                                StudentRepositoryInterface $studentRepository,
                                DepartmentRepositoryInterface $departmentRepository,
                                ResultRepositoryInterface $resultRepository,
                                SubjectRepositoryInterface $subjectRepository)
    {
        $this->_userRepository = $userRepository;
        $this->_studentRepository = $studentRepository;
        $this->_departmentRepository = $departmentRepository;
        $this->_resultRepository = $resultRepository;
        $this->_subjectRepository = $subjectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student_id = Auth::id();
        $student = $this->_studentRepository->findStudentById($student_id);

        return response()->view('users.index', compact('student'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = $this->_studentRepository->findStudentByID($id);
        $departments = $this->_departmentRepository->index();

        return response()->view('users.edit', compact('departments', 'student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     */
    public function update(StudentRequest $request, $id)
    {
        $this->_studentRepository->updateStudent($id, $request->all());

        return redirect('/users')->with('notification', 'Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function createUser(Request $request, $id)
    {
        $details['student_id'] = $id;
        $details['email'] = $request->email;
        $details['password'] = Str::random(10);
        $user = $this->_userRepository->createUser($details);

        return $user;
    }

    public function getResult($id)
    {
        $results = $this->_resultRepository->getResultByStudentID($id);
        $gpa = $this->_resultRepository->getGPA($id);
        $student = $this->_studentRepository->findStudentById($id);
        $department_id = $this->_studentRepository->getDepartment($id)->department_id;
//        $subject = $this->_subjectRepository->getSubject($department_id);
        $studied_subject = [];
        foreach ($results as $result){
            array_push($studied_subject,$result->name);
        }
        $enrollable_subjects = array_values(array_diff($subject,$studied_subject));

        return view('users.user_result',compact('results','gpa','student','enrollable_subjects'));

    }

    public function changeLanguage($language)
    {
        Session::put('website_language', $language);

        return redirect()->back();
    }
}
