<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResultRequest;
use App\Http\Requests\ResultRequest2;
use App\Repositories\RepositoryInterface\DepartmentRepositoryInterface;
use App\Repositories\RepositoryInterface\ResultRepositoryInterface;
use App\Repositories\RepositoryInterface\StudentRepositoryInterface;
use App\Repositories\RepositoryInterface\SubjectRepositoryInterface;

class ResultController extends Controller
{
    protected $_resultRepository;
    protected $_subjectRepository;
    protected $_studentRepository;
    protected $_departmentRepository;

    public function __construct(ResultRepositoryInterface $resultRepository,
                                SubjectRepositoryInterface $subjectRepository,
                                StudentRepositoryInterface $studentRepository,
                                DepartmentRepositoryInterface $departmentRepository)
    {
        $this->_departmentRepository = $departmentRepository;
        $this->_resultRepository = $resultRepository;
        $this->_subjectRepository = $subjectRepository;
        $this->_studentRepository = $studentRepository;
    }

    /**
     * Show result list
     *
     */
    public function index()
    {
        $results = $this->_resultRepository->index();

        return response()->view('results.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $subjects = $this->_subjectRepository->index();

        return response()->view('results.create', compact('subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ResultRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ResultRequest2 $request)
    {
        $subject = $this->checkSubjectOfStudent($request->student_id, $request->subject_id);
        if ($subject === null) {
            return redirect()->back()->with('notification', 'Failed. This subject does not exist in this student\'s department');
        }
        $this->_resultRepository->createResult($request->all());

        return redirect('/results')->with('notification', 'Added Successfully');
    }


    public function show($slug)
    {
        $result = $this->_resultRepository->find($slug);

        return response()->view('results.show', compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $result = $this->_resultRepository->find($slug);
        $subjects = $this->_subjectRepository->index();
        return response()->view('results.edit', compact('result', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ResultRequest2 $request
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ResultRequest2 $request, $slug)
    {
        $result = $this->_resultRepository->updateResult($slug, $request->all());
        if ($result === false) {
            return redirect('/results')->with('notification', 'Update Failed');
        } else {
            return redirect('/results')->with('notification', 'Update Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->_resultRepository->deleteResult($id);

        return redirect('/results')->with('notification', 'Delete Successfully');
    }

    public function checkSubjectOfStudent($student_id, $subject_id)
    {
        $student = $this->_studentRepository->findStudentById($student_id);
        $department_id = $student->department_id;
        $subject = $this->_subjectRepository->getSubjectByDepartment($department_id, $subject_id);

        return $subject;
    }

    public function massiveUpdate(ResultRequest $request)
    {
        $student_id = $request->student_id;
        $student = $this->_studentRepository->findStudentByID($student_id);
        $department_id = $student->department_id;
        $department = $this->_departmentRepository->findByID($department_id);
        $department_name = $department->name;
        if (!array_key_exists('mark', $request->all())) {
            $this->_resultRepository->deleteResultByStudentID($student_id);
            return redirect()->back()->with('notification', 'Update Successfully')->with('department_name', $department_name)->with('student', $student);
        } else {
            $results = $this->_resultRepository->massiveUpdateResult($request->all(), $student);
            $subjects = $this->_subjectRepository->getSubjectByDepartmentID($department_id);

            return redirect()->back()->with('student', $student)->with('subjects', $subjects)->with('department_name', $department_name)->with('results', $results)->with('subjects', $subjects)
                ->with('notification', 'Update Successfully');
        }
    }
}
