<?php

namespace App\Repositories;

use App\Models\Subject;
use App\Repositories\Repository_Interface\SubjectRepositoryInterface;

class SubjectRepository extends EloquentRepository implements SubjectRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Subject::class;
    }

    public function index()
    {
        return parent::getAll();
    }

    public function createSubject(array $attribute)
    {
        return parent::create($attribute);
    }

    public function deleteSubject($id)
    {
        return parent::delete($id);
    }

    public function updateSubject($id, array $attribute)
    {
        return parent::update($id, $attribute);
    }

    public function deleteDepartmentSubject($id)
    {
        $result = Subject::where('department_id','=',$id);
        if($result){
            $result->delete();

            return true;
        }else{
            return false;
        }
    }

}
