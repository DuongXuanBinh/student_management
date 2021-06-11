<?php

namespace App\Http\Controllers;

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
        $result = $this->_departmentController->index();

        return $result;
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
