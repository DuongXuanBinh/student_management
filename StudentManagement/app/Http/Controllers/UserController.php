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
        $email = Auth::user()->email;
        $id = $this->_studentRepository->getIDByMail($email);
        $user = $this->_studentRepository->findStudentById($id);

        return response()->view('users.index', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $email = Auth::user()->email;
        $id = $this->_studentRepository->getIDByMail($email);
        $user = $this->_studentRepository->findStudentById($id);
        $departments = $this->_departmentRepository->index();

        return response()->view('users.edit', compact('departments', 'user'));
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

        return redirect('/user')->with('notification', 'Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function createUser(Request $request)
    {
        $details['email'] = $request->email;
        $details['password'] = Str::random(10);
        $user = $this->_userRepository->createUser($details);

        return $user;
    }

    public function getResult()
    {
        $email = Auth::user()->email;
        $id = $this->_studentRepository->getIDByMail($email);
        $results = $this->_resultRepository->getResultByStudentID($id);
        $gpa = $this->_resultRepository->getGPA($id);
        $user = $this->_studentRepository->findStudentById($id);
        $department_id = $this->_studentRepository->getDepartment($id)->department_id;
        $studied_subject = [];
        foreach ($results as $result) {
            array_push($studied_subject, $result->name);
        }
        $enrollable_subjects = $this->_subjectRepository->getEnrollableSubject($department_id,$studied_subject);

        return view('users.user_result', compact('results', 'gpa', 'user', 'enrollable_subjects'));

    }

    public function enroll(Request $request){
        $this->_resultRepository->enrollSubject($request);

        return back()->with('notification','Enroll Successfully');
    }

}
