<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResultRequest;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\CreateStudentRequest;
use App\Jobs\SendMailDismiss;
use App\Repositories\RepositoryInterface\DepartmentRepositoryInterface;
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
    protected $_departmentRepository;
    protected $_subjectRepository;
    protected $_userRepository;

    public function __construct(StudentRepositoryInterface $studentRepository,
                                DepartmentRepositoryInterface $departmentRepository,
                                SubjectRepositoryInterface $subjectRepository,
                                UserRepositoryInterface $userRepository)
    {
        $this->_studentRepository = $studentRepository;
        $this->_departmentRepository = $departmentRepository;
        $this->_subjectRepository = $subjectRepository;
        $this->_userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $students = $this->_studentRepository->filterStudent($request->all());
        $request->flash();

        return view('students.index',compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = $this->_departmentRepository->getAll();

        return response()->view('students.create', compact('departments'));
    }

    public function store(CreateStudentRequest $request)
    {
        $password = Str::random(8);
        $info = [
            'email' => $request->email,
            'password' => Hash::make($password)
        ];
        DB::beginTransaction();
        try {
            $user = $this->_userRepository->create($info);
            $info = $request->all();
            $info['user_id'] = $user->id;
            $student = $this->_studentRepository->create($info);

            Mail::send('mail.account_mail', compact('student', 'password'), function ($message) use ($student) {
                $message->from('xuanbinh1011@gmail.com', 'ABC University');
                $message->to($student->email, $student->name);
                $message->subject('Account Generation');
            });
            DB::commit();
            return redirect()->route('students.index')->with('notification', 'Successfully added');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('students.index')->with('notification', 'Failed');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $student = $this->_studentRepository->find($slug);

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
        $student = $this->_studentRepository->find($slug);
        $departments = $this->_departmentRepository->getAll();
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
        $this->_userRepository->update($request->user_id,$request->all());
        return $this->_studentRepository->update($slug, $request->all());

    }

    public function destroy($slug)
    {
        $student = $this->_studentRepository->find($slug);
        DB::beginTransaction();
        try {
            $this->_studentRepository->deleteStudentResult($student->id);
            $this->_studentRepository->delete($slug);
            $this->_userRepository->delete($student->user_id);
            DB::commit();
            return redirect()->back()->with('notification', 'Successfully deleted');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('notification', 'Failed');
        }
    }

    public function viewMassiveUpdate($slug)
    {
        $student = $this->_studentRepository->find($slug);
        $results = $student->subjects->toArray();
        $department = $this->_departmentRepository->findByID($student->department_id);
        $department_name = $department->name;
        $subjects = $this->_subjectRepository->getSubjectByDepartmentID($student->department_id);

        return view('students.massive-update', compact('student', 'department_name', 'results', 'subjects'));
    }

    public function sendMailDismiss()
    {
        $complete_students = $this->_studentRepository->checkCompletion(1);
        if (count($complete_students) === 0) {
            return redirect()->back()->with('notification', 'All students are still in-progress');
        }
        $bad_students = $this->_studentRepository->getBadStudent();
        $sendEmail = new SendMailDismiss($bad_students);
        $this->dispatch($sendEmail);

        return redirect()->back()->with('notification', 'Send e-mail successfully');
    }

    public function massiveUpdate(ResultRequest $request)
    {
        $this->_studentRepository->massiveUpdateResult($request->all(), $request->student_id);
        $student = $this->_studentRepository->findByID($request->student_id);
        $results = $student->subjects->toArray();
        $department = $this->_departmentRepository->findByID($student->department_id);
        $department_name = $department->name;
        $subjects = $this->_subjectRepository->getSubjectByDepartmentID($student->department_id);

        return redirect()->back()->with('student', $student)->with('department_name', $department_name)->with('results', $results)
            ->with('subjects', $subjects)->with('notification', 'Update Successfully');
    }
}
