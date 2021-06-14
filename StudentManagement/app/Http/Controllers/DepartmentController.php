<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Repositories\Repository_Interface\DepartmentRepositoryInterface;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $_departmentController;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->_departmentController = $departmentRepository;
    }

    public function index()
    {
        $departments = $this->_departmentController->index();

        $subjects = Subject::all();

        return view('department',compact('departments','subjects'));
    }

    public function addNewDepartment(Request $request)
    {

    }

    public function updateDepartment(Request $request)
    {

    }

    public function deleteDepartment(Request $request)
    {

    }
}
