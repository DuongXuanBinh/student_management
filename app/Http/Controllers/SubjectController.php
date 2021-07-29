<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Repositories\RepositoryInterface\DepartmentRepositoryInterface;
use App\Repositories\RepositoryInterface\SubjectRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    protected $_subjectRepository;
    protected $_departmentRepository;

    public function __construct(SubjectRepositoryInterface $subjectRepository,
                                DepartmentRepositoryInterface $departmentRepository)
    {
        $this->_subjectRepository = $subjectRepository;
        $this->_departmentRepository = $departmentRepository;
    }

    public function index()
    {
        $subjects = $this->_subjectRepository->getAll();

        return response()->view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        $subjects = $this->_subjectRepository->getAll();
        $departments = $this->_departmentRepository->getAll();

        return response()->view('subjects.create', compact('subjects', 'departments'));
    }


    public function store(SubjectRequest $request)
    {
        $this->_subjectRepository->create($request->all());

        return redirect('/subjects')->with('notification', 'Added Successfully');

    }

    public function show($slug)
    {
        $subject = $this->_subjectRepository->find($slug);
        $departments = $this->_departmentRepository->getAll();

        return response()->view('subjects.show', compact('subject', 'departments'));
    }

    public function edit($slug)
    {
        $subject = $this->_subjectRepository->find($slug);
        $departments = $this->_departmentRepository->getAll();

        return response()->view('subjects.edit', compact('subject', 'departments'));
    }

    public function update(SubjectRequest $request, $slug)
    {
        $result = $this->_subjectRepository->update($slug, $request->all());
        if ($result === false) {
            return redirect()->back()->with('notification', 'Failed');
        } else {
            return redirect('/subjects')->with('notification', 'Update Successfully');
        }
    }

    public function destroy($slug)
    {
        $id = $this->_subjectRepository->find($slug)->id;
        DB::beginTransaction();
        try {
            $this->_subjectRepository->deleteSubjectResult($id);
            $this->_subjectRepository->delete($slug);
            DB::commit();
            return redirect()->route('subjects.index')->with('notification', 'Delete Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('notification', 'Failed');
        }
    }
}
