<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface\DepartmentRepositoryInterface;

class DepartmentRepository extends EloquentRepository implements DepartmentRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Department::class;
    }

    public function index()
    {
        return parent::getAll();
    }

    public function createDepartment(array $attribute)
    {
        return parent::create($attribute);
    }

    public function deleteDepartment($slug)
    {
        return parent::delete($slug);
    }

    public function updateDepartment($slug, array $attribute)
    {
        return parent::update($slug, $attribute);
    }

    public function find($slug)
    {
        return parent::find($slug);
    }

    public function findByID($id){
        return $this->_model->where('id',$id)->firstOrFail();
    }

}
