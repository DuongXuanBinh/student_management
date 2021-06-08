<?php

namespace App\Repositories\Repository_Interface;

interface ResultRepositoryInterface
{
    /**
     * Get students by range of mark
     * @param $from
     * @param $to
     * @return mixed
     */
    public function findStudentByMarkRange($from, $to);


}
