<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface\SubjectRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SubjectRepository extends EloquentRepository implements SubjectRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Subject::class;
    }

    /**
     * Delete Subject by department id
     * @param $id
     * @return bool
     */
    public function deleteDepartmentSubject($id)
    {
        $result = $this->_model->where('department_id', '=', $id);
        if ($result) {
            $result->delete();

            return true;
        } else {
            return false;
        }
    }

    /**
     * Get subject by department id
     * @param $id
     * @return mixed
     */
    public function getSubjectID($id)
    {
        $subject_id = [];
        $result = $this->_model->select('id')->where('department_id', '=', $id)->get();
        for($i = 0; $i < count($result); $i++){
            array_push($subject_id,$result[$i]->id);
        }

        return $subject_id;
    }

    public function getEnrollableSubject($id, array $studied_subject)
    {
        return $this->_model->select('id','name')->where('department_id', '=', $id)->
            whereNotIn('name',$studied_subject)->get();
    }

    public function getSubjectQuantity()
    {
        return $this->_model->select('department_id', DB::raw('count(*) as num_of_subject'))
            ->groupBy('department_id')->get();
    }

    public function getSubjectByDepartment($department_id,$subject_id)
    {
        return $this->_model->where('department_id', '=', $department_id)->where('id', '=', $subject_id)->first();
    }

    public function getSubjectByDepartmentID($department_id){
        return $this->_model->where('department_id', '=', $department_id)->get();
    }
}
