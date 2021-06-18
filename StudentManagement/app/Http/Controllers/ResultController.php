<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Repositories\Repository_Interface\ResultRepositoryInterface;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    protected $_resultRepository;

    public function __construct(ResultRepositoryInterface $resultRepository)
    {
        $this->_resultRepository = $resultRepository;
    }

    public function index()
    {
        $results = $this->_resultRepository->index();

        return view('results',compact('results'));
    }

    public function addNewResult(Request $request)
    {
        $result = $this->_resultRepository->createResult($request->all());

        return $result;
    }

    public function updateResult(Request $request)
    {
        $id = $request->id;
        $result = $this->_resultRepository->updateResult($id, $request->all());

        return $result;
    }

    public function deleteResult(Request $request)
    {
        $id = $request->id;
        $result = $this->_resultRepository->deleteResult($id);

        return $result;
    }
}
