<?php

namespace App\Repositories\RepositoryInterface;

interface SubjectRepositoryInterface
{
    public function deleteDepartmentSubject($id);

    public function getSubjectID($id);

    public function getSubjectQuantity();

    public function getSubjectByDepartment($department_id,$subject_id);
}
