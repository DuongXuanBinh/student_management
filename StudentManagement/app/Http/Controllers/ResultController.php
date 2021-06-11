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

    public function index()
    {
        $result = $this->_resultRepository->index();

        return back()->with($result);
    }

    public function addNewResult(Request $request)
    {
        $result = $this->_resultRepository->createResult($request->all());

        return $result;
    }

    public function updateNewResult(Request $request)
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

    public function findStudentByMark(Request $request)
    {
        $mark_from = $request->mark_from;
        $mark_to = $request->mark_to;

        $students = $this->_resultRepository->findStudentByMarkRange($mark_from,$mark_to);

        return back()->with('students');
    }
}
