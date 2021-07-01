<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Jobs\SendMailDismiss;
use App\Repositories\RepositoryInterface\DepartmentRepositoryInterface;
use App\Repositories\RepositoryInterface\ResultRepositoryInterface;
use App\Repositories\RepositoryInterface\StudentRepositoryInterface;
use App\Repositories\RepositoryInterface\SubjectRepositoryInterface;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $_studentRepository;
    protected $_resultRepository;
    protected $_departmentRepository;
    protected $_subjectRepository;

    public function __construct(StudentRepositoryInterface $studentRepository,
                                ResultRepositoryInterface $resultRepository,
                                DepartmentRepositoryInterface $departmentRepository,
                                SubjectRepositoryInterface $subjectRepository)
    {
        $this->_studentRepository = $studentRepository;
        $this->_resultRepository = $resultRepository;
        $this->_departmentRepository = $departmentRepository;
        $this->_subjectRepository = $subjectRepository;
    }

    public function index()
    {
        $students = $this->_studentRepository->index();

        return response()->view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = $this->_departmentRepository->index();

        return response()->view('students.create',compact('departments'));
    }

    public function store(StudentRequest $request)
    {
        $this->_studentRepository->createNewStudent($request->all());

        return redirect()->back()->with('notification', 'Successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = $this->_studentRepository->find($id);

        return response()->view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = $this->_studentRepository->find($id);
        $departments = $this->_departmentRepository->index();

        return response()->view('students.edit',compact('departments','student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, $id)
    {
        $result = $this->_studentRepository->updateStudent($id, $request->all());

        dd($result);
    }

    public function destroy($id)
    {
        $delete_result = $this->_resultRepository->deleteStudentResult($id);
        $delete_student = $this->_studentRepository->deleteStudent($id);
        if ($delete_result === true && $delete_student === true) {
            return redirect('/students')->with('notification', 'Successfully deleted');
        } else {
            return back()->with('notification', 'Delete Failed');
        }
    }

    public function filterStudent(Request $request)
    {
        $result_per_student = $this->_resultRepository->getResultQuantity();
        $subject_per_department = $this->_subjectRepository->getSubjectQuantity();
        $students = $this->_studentRepository->filterStudent($request, $result_per_student, $subject_per_department);
        $request->flash();

        return view('students.index', compact('students', 'departments'));
    }

    public function indexMassiveUpdate(Request $request)
    {
        $department_id = $request->department_id;
        $student_id = $request->id;
        $student_name = $request->name;
        $department = $this->_departmentRepository->findSubject($department_id);
        $department_name = $department->name;
        $results = $this->_resultRepository->getResultByStudentID($student_id);
        $subjects = $this->_subjectRepository->getSubjectByDepartmentID($department_id);

        return view('massive-update', compact('student_id', 'student_name', 'department_name', 'results', 'subjects'));
    }

    public function sendMailDismiss()
    {
        $result_per_student = $this->_resultRepository->getResultQuantity();
        $subject_per_department = $this->_subjectRepository->getSubjectQuantity();
        $complete_student = $this->_studentRepository->checkCompletion(1, $result_per_student, $subject_per_department);
        $bad_student = $this->_resultRepository->getBadStudent($complete_student);

        $student_id = $this->_studentRepository->getStudentIDToDismiss($bad_student);
        $sendEmail = new SendMailDismiss($student_id);
        $this->dispatch($sendEmail);

        return redirect()->back()->with('notification', 'Send e-mail successfully');
    }
}
