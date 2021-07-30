<?php

namespace App\Repositories\RepositoryInterface;

interface SubjectRepositoryInterface
{
    public function deleteDepartmentSubject($id);

    public function getSubjectID($id);

    public function getEnrollableSubject($id, array $studied_subject);

    public function getSubjectByDepartment($department_id,$subject_id);

    public function getSubjectByDepartmentID($department_id);

    public function deleteSubjectResult($subject_id);
}
