<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Repositories\RepositoryInterface\DepartmentRepositoryInterface;
use App\Repositories\RepositoryInterface\ResultRepositoryInterface;
use App\Repositories\RepositoryInterface\StudentRepositoryInterface;
use App\Repositories\RepositoryInterface\SubjectRepositoryInterface;

class DepartmentController extends Controller
{
    protected $_departmentRepository;
    protected $_subjectRepository;
    protected $_resultRepository;
    protected $_studentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository,
                                SubjectRepositoryInterface $subjectRepository,
                                ResultRepositoryInterface $resultRepository,
                                StudentRepositoryInterface $studentRepository)
    {
        $this->_departmentRepository = $departmentRepository;
        $this->_subjectRepository = $subjectRepository;
        $this->_resultRepository = $resultRepository;
        $this->_studentRepository = $studentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = $this->_departmentRepository->index();

        return response()->view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = $this->_departmentRepository->index();

        return response()->view('departments.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\DepartmentRequest $request
     * @return
     */
    public function store(DepartmentRequest $request)
    {
        $this->_departmentRepository->createDepartment($request->all());

        return redirect()->back()->with('notification', 'Added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return
     */
    public function show($id)
    {
        $department = $this->_departmentRepository->find($id);

        return response()->view('departments.show', compact('department'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return
     */
    public function edit($id)
    {
        $department = $this->_departmentRepository->find($id);

        return response()->view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     * @param DepartmentRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(DepartmentRequest $request, $id)
    {
        $result = $this->_departmentRepository->updateDepartment($id, $request->all());
        if ($result === false) {
            return back()->with('notification', 'Update Failed');
        } else {
            return back()->with('notification', 'Update Successfully');
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
        $subjects = $this->_subjectRepository->getSubject($id);
        if (count($subjects) != 0) {
            $this->_resultRepository->deleteSubjectResult($subjects);
            $this->_subjectRepository->deleteDepartmentSubject($id);
        }
        $students = $this->_studentRepository->getStudent($id);
        if (count($students) != 0) {
            $this->_studentRepository->deleteDepartmentStudent($id);
        }

        $delete_department = $this->_departmentRepository->deleteDepartment($id);
        if ($delete_department === true) {
            return redirect('/departments')->with('notification', 'Delete Successfully');
        } else {
            return redirect()->back()->with('notification', 'Delete Failed');
        }
    }
}
