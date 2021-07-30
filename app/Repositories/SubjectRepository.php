<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface\SubjectRepositoryInterface;

class SubjectRepository extends EloquentRepository implements SubjectRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Subject::class;
    }

    public function deleteDepartmentSubject($id)
    {
        $result = $this->_model->where('department_id', $id);
        $result->delete();
    }

    public function getSubjectID($id)
    {
        return $this->_model->select('id')->where('department_id', $id)->get()->pluck('id')->toArray();
    }

    public function getEnrollableSubject($id, array $studied_subject)
    {
        return $this->_model->select('id','name')->where('department_id', $id)
        ->whereNotIn('name',$studied_subject)->get();
    }

    public function getSubjectByDepartment($department_id,$subject_id)
    {
        return $this->_model->where('department_id',  $department_id)->where('id',  $subject_id)->first();
    }

    public function getSubjectByDepartmentID($department_id){
        return $this->_model->where('department_id', $department_id)->get();
    }

    public function deleteSubjectResult($subject_id)
    {
        return $this->_model->find($subject_id)->students()->detach();
    }
}
