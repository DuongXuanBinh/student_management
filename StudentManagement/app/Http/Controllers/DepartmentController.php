<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Subject;
use App\Repositories\RepositoryInterface\DepartmentRepositoryInterface;
use App\Repositories\RepositoryInterface\SubjectRepositoryInterface;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $_departmentRepository;
    protected $_subjectRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository, SubjectRepositoryInterface $subjectRepository)
    {
        $this->_departmentRepository = $departmentRepository;
        $this->_subjectRepository = $subjectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = $this->_departmentRepository->index();
        $subjects = Subject::all();

        return response()->view('departments.department', compact('departments', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param DepartmentRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(DepartmentRequest $request, $id)
    {
        $validator = $request->validated();
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('notification', 'Failed');
        } else {
            $result = $this->_departmentRepository->updateDepartment($id, $request->all());
            if ($result === false) {
                return back()->with('notification', 'Update Failed');
            } else {
                return back()->with('notification', 'Update Successfully');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return
     */
    public function destroy($id)
    {
        $delete_subject = $this->_subjectRepository->deleteDepartmentSubject($id);
        $delete_department = $this->_departmentRepository->deleteDepartment($id);
        if ($delete_department === true && $delete_subject === true) {
            return back()->with('notification', 'Delete Successfully');
        } else {
            return back()->with('notification', 'Delete Failed');
        }
    }
}
