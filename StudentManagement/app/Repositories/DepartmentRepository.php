<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface\DepartmentRepositoryInterface;

class DepartmentRepository extends EloquentRepository implements DepartmentRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Department::class;
    }

}
