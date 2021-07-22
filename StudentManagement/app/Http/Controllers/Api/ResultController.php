<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Repositories\RepositoryInterface\StudentRepositoryInterface;
use App\Repositories\RepositoryInterface\SubjectRepositoryInterface;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    protected $_resultRepository;
    protected $_subjectRepository;
    protected $_studentRepository;

    public function __construct(SubjectRepositoryInterface $subjectRepository,
                                StudentRepositoryInterface $studentRepository)
    {
        $this->_subjectRepository = $subjectRepository;
        $this->_studentRepository = $studentRepository;
    }

    public function index()
    {
        $results = $this->_resultRepository->index();

        return $results;
    }

    public function store(Request $request)
    {
        $subject = $this->checkSubjectOfStudent($request->student_id, $request->subject_id);
        if ($subject === null) {
            return null;
        }
        $result = $this->_resultRepository->createResult($request->all());
        return $result;
    }

    public function checkSubjectOfStudent($student_id, $subject_id)
    {
        $student = $this->_studentRepository->findStudentById($student_id);
        $department_id = $student->department_id;
        $subject = $this->_subjectRepository->getSubjectByDepartment($department_id, $subject_id);

        return $subject;
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Result $result)
    {
        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Result $result
     */
    public function update(Request $request, Result $result)
    {
        $result->update($request->all());
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Result $result
     */
    public function destroy(Result $result)
    {
        $result->delete();
    }


}
