<?php

namespace App\Repositories\RepositoryInterface;



use Illuminate\Http\Request;

interface ResultRepositoryInterface
{

    /**
     * Update marks and subjects at the same time
     * @param $array
     * @return mixed
     */
    public function massiveUpdateResult(Request $request);

    public function getBadStudent($complete_student);

    public function deleteStudentResult($id);

    public function deleteSubjectResult($id);

    public function getResultByStudentID($id);

    public function getResultQuantity();
}
