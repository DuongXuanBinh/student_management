<?php

namespace App\Http\Controllers;

use App\Repositories\Repository_Interface\SubjectRepositoryInterface;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $_subjectRepository;

    public function __construct(SubjectRepositoryInterface $subjectRepository)
    {
        $this->_subjectRepository = $subjectRepository;
    }

    public function index(){
        $result = $this->_subjectRepository->index();

        return $result;
    }

    public function createSubject(Request $request){
        $result = $this->_subjectRepository->createSubject($request->all());
    }

    public function updateSubject(Request $request)
    {
        $id = $request->id;
        $result = $this->_subjectRepository->updateSubject($id, $request->all());

        return $result;
    }

    public function deleteSubject(Request $request)
    {
        $id = $request->id;
        $result = $this->_subjectRepository->deleteSubject($id);

        return $result;
    }

}
