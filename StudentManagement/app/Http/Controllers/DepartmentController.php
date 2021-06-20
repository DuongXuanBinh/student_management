<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Repositories\Repository_Interface\DepartmentRepositoryInterface;
use App\Repositories\Repository_Interface\SubjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    protected $_departmentRepository;
    protected $_subjectRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository, SubjectRepositoryInterface $subjectRepository)
    {
        $this->_departmentRepository = $departmentRepository;
        $this->_subjectRepository = $subjectRepository;
    }

    public function index()
    {
        $departments = $this->_departmentRepository->index();

        $subjects = Subject::all();

        return view('department', compact('departments', 'subjects'));
    }

    public function addNewDepartment(Request $request)
    {
        $validator = $this->validateSDepartment($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('notification', 'Failed');
        } else {
            $this->_departmentRepository->createDepartment($request->all());
            return back()->with('notification', 'Added Successfully');
        }
    }

    public function updateDepartment(Request $request)
    {
        $validator = $this->validateSDepartment($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('notification', 'Failed');
        } else {
            $id = $request->id;
            $result = $this->_departmentRepository->updateDepartment($id, $request->all());
            if ($result === false) {
                return back()->with('notification', 'Update Failed');
            } else {
                return back()->with('notification', 'Update Successfully');
            }
        }
    }

    public function deleteDepartment(Request $request)
    {
        $id = $request->id;
        $delete_subject = $this->_subjectRepository->deleteDepartmentSubject($id);
        $delete_department = $this->_departmentRepository->deleteDepartment($id);
        if ($delete_department === true && $delete_subject === true) {
            return back()->with('notification', 'Delete Successfully');
        } else {
            return back()->with('notification', 'Delete Failed');
        }
    }

    public function validateSDepartment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:departments,name,' . $request->id . ',id',
        ]);
        return $validator;
    }
}
