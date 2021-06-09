<?php

namespace App\Http\Controllers;

use App\Repositories\Repository_Interface\ResultRepositoryInterface;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    protected $_resultRepository;

    public function __construct(ResultRepositoryInterface $resultRepository)
    {
        $this->_resultRepository = $resultRepository;
    }
}
