<?php

namespace App\Repositories\RepositoryInterface;



use App\Models\Student;
use Illuminate\Http\Request;

interface ResultRepositoryInterface
{

    /**
     * Update marks and subjects at the same time
     * @param $array
     * @return mixed
     */
    public function massiveUpdateResult(array $request, Student $student);

    public function getBadStudent($complete_student);

    public function deleteStudentResult($id);

    public function deleteSubjectResult($id);

    public function getResultByStudentID($id);

    public function getGPA($id);

    public function deleteResultByStudentID($id);

    public function enrollSubject(array $request);
}
