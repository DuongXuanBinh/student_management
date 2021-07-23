<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Repositories\RepositoryInterface\DepartmentRepositoryInterface;
use App\Repositories\RepositoryInterface\StudentRepositoryInterface;
use App\Repositories\RepositoryInterface\SubjectRepositoryInterface;
use App\Repositories\RepositoryInterface\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    protected $_departmentRepository;
    protected $_subjectRepository;
    protected $_studentRepository;
    protected $_userRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository,
                                SubjectRepositoryInterface $subjectRepository,
                                StudentRepositoryInterface $studentRepository,
                                UserRepositoryInterface $userRepository)
    {
        $this->_departmentRepository = $departmentRepository;
        $this->_subjectRepository = $subjectRepository;
        $this->_studentRepository = $studentRepository;
        $this->_userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = $this->_departmentRepository->getAll();

        return response()->view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = $this->_departmentRepository->getAll();

        return response()->view('departments.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DepartmentRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(DepartmentRequest $request)
    {
        $this->_departmentRepository->create($request->all());

        return redirect('/departments')->with('notification', 'Added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $department = $this->_departmentRepository->find($slug);

        return response()->view('departments.show', compact('department'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $department = $this->_departmentRepository->find($slug);

        return response()->view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     * @param DepartmentRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(DepartmentRequest $request, $slug)
    {
        $result = $this->_departmentRepository->update($slug, $request->all());
        if ($result === false) {
            return redirect()->back()->with('notification', 'Update Failed');
        } else {
            return redirect('/departments')->with('notification', 'Update Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return
     */
    public function destroy($slug)
    {
        $id = $this->_departmentRepository->find($slug)->id;
        $subjects = $this->_subjectRepository->getSubjectID($id);
        $students = $this->_studentRepository->getStudent($id);
        DB::beginTransaction();
        try {
            if (count($subjects) > 0) {
                $this->_studentRepository->deleteSubjectResult($subjects);
                $this->_subjectRepository->deleteDepartmentSubject($id);
            }
            if (count($students) > 0) {
                $this->_studentRepository->deleteDepartmentStudent($id);
            }
            $this->_userRepository->delete($students);
            $this->_departmentRepository->delete($slug);
            DB::commit();
            return redirect()->back()->with('notification', 'Delete Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('notification', 'Delete Failed');
        }
    }
}
