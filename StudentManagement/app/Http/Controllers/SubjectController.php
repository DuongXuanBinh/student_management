<?php

namespace App\Http\Controllers;

use App\Repositories\Repository_Interface\ResultRepositoryInterface;
use App\Repositories\Repository_Interface\SubjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    protected $_subjectRepository;
    protected $_resultRepository;

    public function __construct(SubjectRepositoryInterface $subjectRepository, ResultRepositoryInterface $resultRepository)
    {
        $this->_resultRepository = $resultRepository;
        $this->_subjectRepository = $subjectRepository;
    }

    public function index()
    {
        $subjects = $this->_subjectRepository->index();

        return view('department', compact('subjects'));
    }


    public function addNewSubject(Request $request)
    {
        $validator = $this->validateSubject($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('notification', 'Failed');
        } else {
            $this->_subjectRepository->createSubject($request->all());

            return back()->with('notification', 'Added Successfully');
        }

    }

    public function updateSubject(Request $request)
    {
        $validator = $this->validateSubject($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('notification', 'Failed');
        } else {
            $id = $request->id;
            $result = $this->_subjectRepository->updateSubject($id, $request->all());
            if ($result === false) {
                return back()->with('notification', 'Update Failed');
            } else {
                return back()->with('notification', 'Update Successfully');
            }
        }
    }

    public function deleteSubject(Request $request)
    {
        $id = $request->id;
        $delete_result= $this->_resultRepository->deleteSubjectResult($id);
        $delete_subject = $this->_subjectRepository->deleteSubject($id);
        if($delete_subject === true && $delete_result === true){
            return back()->with('notification', 'Delete Successfully');
        } else {
            return back()->with('notification', 'Delete Failed');
        }
    }

    public function validateSubject(Request $request)
    {
        $name = $request->name;
        $department_id = $request->department_id;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'department_id' => ['required', Rule::unique('subjects')->where(function ($query) use ($name, $department_id) {
                return $query->where('name', '=', $name)->where('department_id', '=', $department_id);
            })->ignore($request->id)],
        ]);

        return $validator;
    }

}
