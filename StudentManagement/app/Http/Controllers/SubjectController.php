<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Repositories\RepositoryInterface\DepartmentRepositoryInterface;
use App\Repositories\RepositoryInterface\ResultRepositoryInterface;
use App\Repositories\RepositoryInterface\SubjectRepositoryInterface;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $_subjectRepository;
    protected $_resultRepository;
    protected $_departmentRepository;

    public function __construct(SubjectRepositoryInterface $subjectRepository,
                                ResultRepositoryInterface $resultRepository,
                                DepartmentRepositoryInterface $departmentRepository)
    {
        $this->_resultRepository = $resultRepository;
        $this->_subjectRepository = $subjectRepository;
        $this->_departmentRepository = $departmentRepository;
    }

    public function index()
    {
        $subjects = $this->_subjectRepository->index();

        return response()->view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        $subjects = $this->_subjectRepository->index();
        $departments = $this->_departmentRepository->index();

        return response()->view('subjects.create', compact('subjects', 'departments'));
    }


    public function store(SubjectRequest $request)
    {
        $this->_subjectRepository->createSubject($request->all());

        return redirect('/subjects')->with('notification', 'Added Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $subject = $this->_subjectRepository->find($slug);
        $departments = $this->_departmentRepository->index();

        return response()->view('subjects.show', compact('subject', 'departments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $subject = $this->_subjectRepository->find($slug);
        $departments = $this->_departmentRepository->index();

        return response()->view('subjects.edit', compact('subject', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\SubjectRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SubjectRequest $request, $slug)
    {
        $result = $this->_subjectRepository->updateSubject($slug, $request->all());
        if ($result === false) {
            return redirect()->back()->with('notification', 'Update Failed');
        } else {
            return redirect('/subjects')->with('notification', 'Update Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($slug)
    {
        $id = $this->_subjectRepository->find($slug)->id;
        $delete_result = $this->_resultRepository->deleteSubjectResult($id);
        $delete_subject = $this->_subjectRepository->deleteSubject($slug);
        if ($delete_subject === true && $delete_result === true) {
            return redirect('/subjects')->with('notification', 'Delete Successfully');
        } else {
            return redirect()->back()->with('notification', 'Delete Failed');
        }
    }
}
