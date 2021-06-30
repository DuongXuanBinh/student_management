<?php

namespace App\Repositories;

use App\Models\Result;
use App\Repositories\RepositoryInterface\ResultRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ResultRepository extends EloquentRepository implements ResultRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Result::class;
    }

    public function index()
    {
        return parent::getAll();
    }

    public function createResult(array $attribute)
    {
        return parent::create($attribute);
    }

    public function deleteResult($id)
    {
        return parent::delete($id);
    }

    public function updateResult($id, array $attribute)
    {
        return parent::update($id, $attribute);
    }

    public function find($id)
    {
        return parent::find($id);
    }

    public function massiveUpdateResult(Request $request)
    {
//        if ($request->id != null) {
//            $id = [];
//        } else {
//            $id = $request->id;
//        }
//        $subject_id = $request->subject_id;
//        $student_id = $request->student_id;
//        $mark = $request->mark;
//        for ($i = 0; $i < count($id); $i++) {
//            $result = Result::find($id[$i]);
//            $result->subject_id = $subject_id[$i];
//            $result->student_id = $student_id[$i];
//            $result->mark = $mark[$i];
//            $result->save();
//        };
//        for ($j = count($id); $j < count($subject_id); $j++) {
//            $result = Result::create([
//                'subject_id' => $subject_id[$j],
//                'student_id' => $student_id[$j],
//                'mark' => $mark[$j]
//            ]);
//        }
//
//        return true;
    }

    /**
     * Delete result by student id
     * @param $id
     * @return bool
     */
    public function deleteStudentResult($id)
    {
        $result = Result::where('student_id', '=', $id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    /**
     * Delete result by subject id
     * @param $id
     * @return bool
     */
    public function deleteSubjectResult($id)
    {
        $result = Result::where('subject_id', '=', $id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    /**
     * Get result by student id
     * @param $id
     * @return mixed
     */
    public function getResultByStudentID($id)
    {
        $result = Result::select('results.*', 'subjects.name')
            ->join('subjects', 'subjects.id', 'results.subject_id')
            ->where('student_id', '=', $id)->get();
        return $result;
    }

    public function getResultQuantity()
    {
        $result = Result::select('student_id', 'department_id', DB::raw('count(mark) as num_of_result'))
            ->join('students', 'students.id', 'results.student_id')
            ->groupBy('student_id', 'department_id')
            ->orderBy('student_id', 'asc')->get();

        return $result;
    }

    public function getBadStudent($complete_student)
    {
        $dismiss_student = Result::select('student_id', DB::raw('avg(mark) as average_mark'))
            ->whereIn('student_id', $complete_student)
            ->groupBy('student_id')->having('average_mark', '<', 5)
            ->get();

        return $dismiss_student;
    }
}
