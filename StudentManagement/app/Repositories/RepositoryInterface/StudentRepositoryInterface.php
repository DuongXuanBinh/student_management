<?php
namespace App\Repositories\RepositoryInterface;

use Illuminate\Http\Request;

interface StudentRepositoryInterface
{
    public function filterStudent(Request $request, $result_per_student, $subject_per_department);

    public function checkCompletion($type, $result_of_student, $num_of_subject);

    public function getStudentIDToDismiss($dismiss_student);
}
