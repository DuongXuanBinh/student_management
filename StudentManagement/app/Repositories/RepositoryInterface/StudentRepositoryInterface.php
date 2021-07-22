<?php

namespace App\Repositories\RepositoryInterface;

interface StudentRepositoryInterface
{
    public function filterStudent(array $data);

    public function checkCompletion($type);

    public function getStudentIDToDismiss($dismiss_student);

    public function deleteDepartmentStudent($id);

    public function getStudent($department_id);

    public function getDepartment($student_id);

    public function getIDByMail($email);

    public function enrollSubject($request);

    public function massiveUpdateResult($request, $student_id);

    public function deleteSubject($ids);

    public function getGPA($id);

    public function getResultByStudentID($id);

    public function getBadStudent();

    public function deleteStudentResult($id);
}
