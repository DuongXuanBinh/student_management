<?php

namespace App\Repositories;

use App\Models\Result;
use App\Models\Student;
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

    public function massiveUpdateResult(Request $request, Student $student)
    {
        $subject_id = $request->subject_id;
        $mark = $request->mark;
        for ($i = 0; $i < count($subject_id); $i++) {
            $subject[$subject_id[$i]] = ['mark' => $mark[$i]];
        }
        $student->subjects()->sync($subject);

        $result = $this->getResultByStudentID($student->id);
        return $result;
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
        if (is_array($id)) {
            $result = Result::whereIn('subject_id', $id);
        } else {
            $result = Result::where('subject_id', $id);
        }
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

    public function getGPA($id)
    {
        $result = Result::select(DB::raw(' AVG(mark) as GPA'))
            ->where('student_id',$id)
            ->groupBy('student_id')->first();
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

    public function getStudentByMarkRange($from, $to)
    {
        $results = Result::select('student_id')->where('mark', '>=', $from)->where('mark', '<=', $to)->distinct()->get();
        $student_id=[];
        foreach ($results as $result){
            array_push($student_id,$result->student_id);
        }

        return $student_id;
    }

    public function enrollSubject(Request $request){
        Result::create(['student_id'=>$request->id,
           'subject_id' => $request->name,
           'mark' => 0
        ]);

    }
}
