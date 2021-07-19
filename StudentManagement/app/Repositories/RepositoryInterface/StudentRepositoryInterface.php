<?php

namespace App\Repositories\RepositoryInterface;

use Illuminate\Http\Request;

interface StudentRepositoryInterface
{
    public function filterStudent(array $data);

    public function checkCompletion($type, $result_of_student, $num_of_subject);

    public function getStudentIDToDismiss($dismiss_student);

    public function deleteDepartmentStudent($id);

    public function getStudent($department_id);

    public function getDepartment($student_id);

    public function getIDByMail($email);

    public function findStudentByID($id);
}
