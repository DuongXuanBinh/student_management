<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Jobs\SendMailDismiss;
use App\Repositories\RepositoryInterface\DepartmentRepositoryInterface;
use App\Repositories\RepositoryInterface\ResultRepositoryInterface;
use App\Repositories\RepositoryInterface\StudentRepositoryInterface;
use App\Repositories\RepositoryInterface\SubjectRepositoryInterface;
use App\Repositories\RepositoryInterface\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    protected $_studentRepository;
    protected $_resultRepository;
    protected $_departmentRepository;
    protected $_subjectRepository;
    protected $_userRepository;

    public function __construct(StudentRepositoryInterface $studentRepository,
                                ResultRepositoryInterface $resultRepository,
                                DepartmentRepositoryInterface $departmentRepository,
                                SubjectRepositoryInterface $subjectRepository,
                                UserRepositoryInterface $userRepository)
    {
        $this->_studentRepository = $studentRepository;
        $this->_resultRepository = $resultRepository;
        $this->_departmentRepository = $departmentRepository;
        $this->_subjectRepository = $subjectRepository;
        $this->_userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $students = $this->_studentRepository->filterStudent($request->all());
        $request->flash();
        return response()->view('students.index',compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = $this->_departmentRepository->index();

        return response()->view('students.create', compact('departments'));
    }

    public function store(StudentRequest $request)
    {
        $student = $this->_studentRepository->createNewStudent($request->all());
        $password = Str::random(8);
        $user = [
            'student_id' => $student->id,
            'email' => $student->email,
            'password' => Hash::make($password)
        ];
        $this->_userRepository->createUser($user);
        Mail::send('mail.account_mail',compact('student','password'),function ($message) use ($student){
            $message->from('xuanbinh1011@gmail.com','ABC University');
            $message->to($student->email,$student->name);
            $message->subject('Account Generation');
        });
        return redirect()->back()->with('notification', 'Successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $student = $this->_studentRepository->findStudent($slug);

        return response()->view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $student = $this->_studentRepository->findStudent($slug);
        $departments = $this->_departmentRepository->index();

        return response()->view('students.edit', compact('departments', 'student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, $slug)
    {
        $result = $this->_studentRepository->updateStudent($slug, $request->all());

        return $result;
    }

    public function destroy($slug)
    {
        $id = $this->_studentRepository->findStudent($slug)->id;
        DB::beginTransaction();
        try {
            $this->_resultRepository->deleteStudentResult($id);
            $this->_studentRepository->deleteStudent($slug);
            DB::commit();
            return redirect()->back()->with('notification', 'Successfully deleted');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('notification', 'Delete Failed');
        }
    }

    public function viewMassiveUpdate($slug)
    {
        $student = $this->_studentRepository->findStudent($slug);
        $department_id = $student->department_id;
        $student_id = $student->id;
        $department = $this->_departmentRepository->findByID($department_id);
        $department_name = $department->name;
        $results = $this->_resultRepository->getResultByStudentID($student_id);
        $subjects = $this->_subjectRepository->getSubjectByDepartmentID($department_id);
        return view('students.massive-update', compact('student', 'department_name', 'results', 'subjects'));
    }

    public function sendMailDismiss()
    {
        $complete_student = $this->_studentRepository->checkCompletion(1);
        if(count($complete_student) === 0){
            return redirect()->back()->with('notification', 'No student with GPA under 5 this time');
        }
        $bad_student = $this->_resultRepository->getBadStudent($complete_student);

        $student_id = $this->_studentRepository->getStudentIDToDismiss($bad_student);
        $sendEmail = new SendMailDismiss($student_id);
        $this->dispatch($sendEmail);

        return redirect()->back()->with('notification', 'Send e-mail successfully');
    }
}
