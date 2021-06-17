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
        $validator = $this->validateStudent($request);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator)->with('notification', 'Failed');
        } else {
            $result = $this->_studentRepository->createNewStudent($request->all());
            $id = $result->id;

            return back()->with('notification', 'Successfully added');
        }
    }

    public function deleteStudent(Request $request)
    {
        $id = $request->id;
        $result = $this->_studentRepository->deleteStudent($id);

        return back()->with('notification', 'Successfully deleted');
    }

    public function index()
    {
        $students = $this->_studentRepository->index();
        $departments = Department::all();

        return view('student', compact('students', 'departments'));
    }

    public function updateStudent(Request $request)
    {

        $validator = $this->validateStudent($request);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator)->with('notification', 'Failed');
        } else {
            $id = $request->id;
            $result = $this->_studentRepository->updateStudent($id, $request->all());
        }

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
            'email' => 'required|email',Rule::unique('students','email')->ignore($request->email),
            'gender' => ['required', Rule::in(['0', '1'])],
            'birthday' => 'required|date',
            'address' => 'required',
            'phone' => 'required|regex:/^(09)[0-9]{8}$/',Rule::unique('students','phone')->ignore($request->phone),
        ], $message);

        return $validator;
    }

    public function createAccount(Request $request, $id)
    {

    }

}
