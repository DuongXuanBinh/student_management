<?php

namespace App\Repositories\Repository_Interface;

interface ResultRepositoryInterface
{

    /**
     * Update marks and subjects at the same time
     * @param $array
     * @return mixed
     */
    public function massiveUpdateResult($array);
}
