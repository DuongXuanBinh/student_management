<?php

namespace App\Repositories;

use App\Models\Subject;
use App\Repositories\RepositoryInterface\SubjectRepositoryInterface;
use Illuminate\Support\Facades\DB;

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

    /**
     * Delete Subject by department id
     * @param $id
     * @return bool
     */
    public function deleteDepartmentSubject($id)
    {
        $result = Subject::where('department_id', '=', $id);
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
    public function getSubject($id)
    {
        $result = Subject::select('id', 'name')->where('department_id', '=', $id)->get();

        return $result;
    }

    public function getSubjectQuantity()
    {
        $num_of_subject = Subject::select('department_id', DB::raw('count(*) as num_of_subject'))
            ->groupBy('department_id')->get();

        return $num_of_subject;
    }
    public function getSubjectByDepartment($department_id,$subject_id)
    {
        $subject = Subject::where('department_id', '=', $department_id)->where('id', '=', $subject_id)->first();

        return $subject;
    }
}
