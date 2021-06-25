<?php

namespace App\Repositories\Repository_Interface;



use Illuminate\Http\Request;

interface ResultRepositoryInterface
{

    /**
     * Update marks and subjects at the same time
     * @param $array
     * @return mixed
     */
    public function massiveUpdateResult(Request $request);
}
