<?php

namespace App\Repositories;

use App\Repositories\Repository_Interface\ResultRepositoryInterface;

class ResultRepository extends EloquentRepository implements ResultRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Result::class;
    }

    public function findStudentByMarkRange($from, $to)
    {
        // TODO: Implement findStudentByMarkRange() method.
    }

    public function updateResult($array)
    {
        // TODO: Implement updateResult() method.
    }
}
