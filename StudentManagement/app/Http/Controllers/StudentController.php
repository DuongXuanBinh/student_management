<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Repositories\Repository_Interface\StudentRepositoryInterface;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:30',
            'department_id' => ['required', Rule::in(['1', '2', '3', '4', '5', '6'])],
            'email' => 'required|email|unique:students,email',
            'gender' => ['required', Rule::in(['0', '1'])],
            'birthday' => 'required|date',
            'address' => 'required',
            'phone' => 'required|regex:/^(09)[0-9]{8}$/|unique:students,phone',
        ], $message);

        if ($validator->fails()) {
            dd($message);
            return back()->withErrors($validator);
        } else {
            dd('1');
            $result = $this->_studentRepository->createNewStudent($request->all());
            return back()->with('notification', 'Successfully added');
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
        $students = $this->_studentRepository->index();
        $departments = Department::all();

        return view('student', compact('students', 'departments'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:30',
            'department_id' => ['required', Rule::in(['1', '2', '3', '4', '5', '6'])],
            'email' => ['required|email', Rule::unique('students', 'email')->ignore($request->email)],
            'gender' => ['required', Rule::in(['0', '1'])],
            'birthday' => 'required|date_format:Y-m-d|before:2007-01-01',
            'address' => 'required',
            'phone' => ['required|regex/^(09)[0-9]{8}$/', Rule::unique('students', 'phone')->ignore($request->phone)]
        ], $message);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $id = $request->id;
            $result = $this->_studentRepository->updateStudent($id, $request->all());

            return $result;
        }
    }

    public function filterStudent(Request $request)
    {
        $students = $this->_studentRepository->filterStudent($request);
        $departments = Department::all();
        return view('student',compact('students','departments'));
    }


}
