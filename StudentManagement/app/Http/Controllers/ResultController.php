<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Student;
use App\Models\Subject;
use App\Repositories\Repository_Interface\ResultRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $subjects = Subject::all()->sortBy('name');

        return view('results', compact('results', 'subjects'));
    }

    public function addNewResult(Request $request)
    {
        $validator = $this->validateResult($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('notification', 'Failed');
        } else {
            $check_subject = $this->checkSubjectOfStudent($request->student_id, $request->subject_id);
            if ($check_subject === null) {
                return back()->with('notification', 'Failed. This subject does not exist in this student\'s department');
            }
            $result = $this->_resultRepository->createResult($request->all());
            return back()->with('notification', 'Added Successfully');
        }
    }

    public function updateResult(Request $request)
    {
        $validator = $this->validateResult($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('notification', 'Failed');
        } else {
            $id = $request->id;
            $check_subject = $this->checkSubjectOfStudent($request->student_id, $request->subject_id);

            if ($check_subject === null) {
                return back()->with('notification', 'Failed. This subject does not exist in this student\'s department');
            } else {
                $result = $this->_resultRepository->updateResult($id, $request->all());
                if ($result === false) {
                    return back()->with('notification', 'Update Failed');
                } else {
                    return back()->with('notification', 'Update Successfully');
                }
            }
        }
    }

    public function deleteResult(Request $request)
    {
        $id = $request->id;
        $this->_resultRepository->deleteResult($id);

        return back()->with('notification', 'Delete Successfully');
    }

    public function checkSubjectOfStudent($student_id, $subject_id)
    {
        $check_department = Student::where('id', '=', $student_id)->first();
        $department_id = $check_department->department_id;
        $check_subject = Subject::where('department_id', '=', $department_id)->where('id', '=', $subject_id)->first();

        return $check_subject;
    }

    public function validateResult(Request $request)
    {
        $subject_id = $request->subject_id;
        $student_id = $request->student_id;
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'subject_id' => ['required', 'exists:subjects,id', Rule::unique('results')->where(function ($query) use ($student_id, $subject_id) {
                return $query->where('student_id', '=', $student_id)
                    ->where('subject_id', '=', $subject_id);
            })->ignore($request->id)],
            'mark' => 'required|numeric|min:0|max:10',
        ]);
        return $validator;
    }

    public function massiveUpdate(Request $request)
    {
        $result = $this->_resultRepository->massiveUpdateResult($request);
        if ($result) {
            return back()->with('notification', 'Update result successfully');
        } else {
            return back()->with('notification','Failed');
        }
    }
}
