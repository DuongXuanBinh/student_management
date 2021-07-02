<?php

namespace App\Repositories;

use App\Models\Subject;
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

    public function deleteDepartment($id)
    {
        return parent::delete($id);
    }

    public function updateDepartment($id, array $attribute)
    {
        return parent::update($id, $attribute);
    }

    public function find($id)
    {
        return parent::find($id);
    }
}
