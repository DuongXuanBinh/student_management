<?php

namespace App\Http\Controllers;

use App\Repositories\Repository_Interface\StudentRepositoryInterface;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    protected $_studentRepository;

    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->_studentRepository = $studentRepository;
    }

    public function addNewStudent(Request $request)
    {
        $message = [
            'email.unique' => 'Email is already exist',
            'phone.unique' => 'Phone number is already exist',
            'required' => 'All information is required',
            'before' => 'Under 15 is not eligible',
            'regex' => 'Phone number is in wrong format'
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:30',
            'department_id' => ['required',Rule::in(['1','2','3','4','5','6'])],
            'email' => 'required|email|unique:students,email',
            'gender' => ['required',Rule::in(['0','1'])],
            'birthday' => 'required|date|before:',
            'address' => 'required',
            'phone' =>'required|regex/^(09)[0-9]{8}$/|unique:students,phone',
        ],$message);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else{
            $result = $this->_studentRepository->createNewStudent($request->all());
            //lay thong tin user
            return back()->with('notification','Successfully added');
        }
    }

    public function deleteStudent(Request $request)
    {
        $id = $request->id;

        $result = $this->_studentRepository->deleteStudent($id);

        return $result;
    }

    public function index()
    {
        $indices = $this->_studentRepository->index();

        return view('student',compact($indices));
    }

    public function updateStudent(Request $request)
    {
        $message = [
            'email.unique' => 'Email is already exist',
            'phone.unique' => 'Phone number is already exist',
            'required' => 'All information is required',
            'before' => 'Under 15 is not eligible',
            'regex' => 'Phone number is in wrong format'
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:30',
            'department_id' => ['required',Rule::in(['1','2','3','4','5','6'])],
            'email' => ['required|email',Rule::unique('students','email')->ignore($request->email)],
            'gender' => ['required',Rule::in(['0','1'])],
            'birthday' => 'required|date_format:Y-m-d|before:2007-01-01',
            'address' => 'required',
            'phone' =>['required|regex/^(09)[0-9]{8}$/',Rule::unique('students','phone')->ignore($request->phone)]
        ],$message);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $id = $request->id;
            $result = $this->_studentRepository->updateStudent($id, $request->all());

            return $result;
        }
    }

    public function findByAgeRange(Request $request)
    {
        $from = $request -> from;
        $to = $request ->to;
        $students = $this->_studentRepository->findStudentByAgeRange($from, $to);

        return back()->with($students);
    }

    public function findByMobileOperator(Request $request)
    {
        $operator = $request -> operator;
        $students = $this->_studentRepository->findStudentByPhone($operator);

        return back()->with($students);
    }

    public function incompleteStudents()
    {
        $students = $this->_studentRepository->incompleteStudent();

        return back()->with('students');
    }

    public function completedStudent()
    {
        $students = $this->_studentRepository->completedStudent();

        return back()->with('students');
    }


}
