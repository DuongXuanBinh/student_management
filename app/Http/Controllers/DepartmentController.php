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

    public function index()
    {
        $departments = $this->_departmentRepository->getAll();

        return response()->view('departments.index', compact('departments'));
    }

    public function create()
    {
        $departments = $this->_departmentRepository->getAll();

        return response()->view('departments.create', compact('departments'));
    }

    public function store(DepartmentRequest $request)
    {
        $this->_departmentRepository->create($request->all());

        return redirect()->route('departments.index')->with('notification', 'Added successfully');
    }

    public function show($slug)
    {
        $department = $this->_departmentRepository->find($slug);

        return response()->view('departments.show', compact('department'));

    }

    public function edit($slug)
    {
        $department = $this->_departmentRepository->find($slug);

        return response()->view('departments.edit', compact('department'));
    }

    public function update(DepartmentRequest $request, $slug)
    {
        $result = $this->_departmentRepository->update($slug, $request->all());

        if ($result === false) {
            return redirect()->back()->with('notification', 'Update Failed');
        } else {
            return redirect()->route('departments.index')->with('notification', 'Update Successfully');
        }
    }

    public function destroy($slug)
    {
        $department_id = $this->_departmentRepository->find($slug)->id;
        $subjects = $this->_subjectRepository->getSubjectID($department_id);
        $user_ids = $this->_studentRepository->getUser($department_id);

        DB::beginTransaction();
        try {
            $this->_studentRepository->deleteResults($department_id, $subjects);
            $this->_subjectRepository->deleteDepartmentSubject($department_id);
            $this->_studentRepository->deleteDepartmentStudent($department_id);
            $this->_userRepository->delete($user_ids);
            $this->_departmentRepository->delete($slug);
            DB::commit();
            return redirect()->back()->with('notification', 'Delete Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('notification', 'Delete Failed');
        }
    }
}
