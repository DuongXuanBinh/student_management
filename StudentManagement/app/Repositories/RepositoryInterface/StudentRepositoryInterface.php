<?php

namespace App\Repositories\RepositoryInterface;

interface StudentRepositoryInterface
{
    public function filterStudent(array $data);

    public function checkCompletion($type);

    public function deleteDepartmentStudent($id);

    public function getUser($department_id);

    public function checkUserByMail($email);

    public function enrollSubject($request);

    public function massiveUpdateResult($request, $student_id);

    public function deleteResults($department_id, array $subject_ids);

    public function getGPA($id);

    public function getResultByStudentID($id);

    public function getBadStudent();

    public function deleteStudentResult($id);
}
