<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Repositories\DepartmentRepository;
use App\Repositories\Repository_Interface\DepartmentRepositoryInterface;
use App\Repositories\Repository_Interface\ResultRepositoryInterface;
use App\Repositories\Repository_Interface\StudentRepositoryInterface;

use App\Repositories\Repository_Interface\SubjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

    public function addNewStudent(Request $request)
    {
        $validator = $this->validateStudent($request);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator)->with('notification', 'Failed');
        } else {
            $result = $this->_studentRepository->createNewStudent($request->all());
//            $id = $result->id;

            return back()->with('notification', 'Successfully added');
        }
    }

    public function deleteStudent(Request $request)
    {
        $id = $request->id;
        $delete_result = $this->_resultRepository->deleteStudentResult($id);
        $delete_student = $this->_studentRepository->deleteStudent($id);
        if($delete_result === true && $delete_student === true) {
            return back()->with('notification', 'Successfully deleted');
        }else{
            return back()->with('notification','Delete Failed');
        }
    }

    public function index()
    {
        $students = $this->_studentRepository->index();
        $departments = Department::all()->sortBy('name');

        return view('student', compact('students', 'departments'));
    }

    public function updateStudent(Request $request)
    {
        $validator = $this->validateStudent($request);
        if ($validator->fails()) {
            $result = $validator->errors()->all();
            array_unshift($result,false);
        } else {
            $id = $request->id;
            $result = $this->_studentRepository->updateStudent($id, $request->all());
        }
        return $result;
    }

    public function filterStudent(Request $request)
    {
        $students = $this->_studentRepository->filterStudent($request);
        $departments = Department::all();

        $request->flash();
        return view('student', compact('students', 'departments'));
    }

    public function validateStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:30',
            'department_id' => ['required', Rule::in(['1', '2', '3', '4', '5'])],
            'email' => ['required','email', Rule::unique('students', 'email')->ignore($request->id)],
            'gender' => ['required', Rule::in(['0', '1'])],
            'birthday' => 'required|date',
            'address' => 'required',
            'phone' => ['required','regex:/^(09)[0-9]{8}$/', Rule::unique('students', 'phone')->ignore($request->id)],
        ]);
        return $validator;
    }

    public function createAccount()
    {

    }

    public function indexMassiveUpdate(Request  $request){
        $department_id = $request->department_id;
        $student_id = $request->id;
        $student_name = $request->name;
        $department = $this->_departmentRepository->findSubject($department_id);
        $department_name = $department->name;
        $results = $this->_resultRepository->getResultByStudentID($student_id);
        $subjects = $this->_subjectRepository->getSubjectByDepartmentID($department_id);

        return view('massive-update',compact('student_id','student_name','department_name','results','subjects'));
    }


}
