<?php

namespace App\Repositories;

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

    public function deleteResult($slug)
    {
        return parent::delete($slug);
    }

    public function updateResult($slug, array $attribute)
    {
        return parent::update($slug, $attribute);
    }

    public function find($slug)
    {
        return parent::find($slug);
    }

    public function massiveUpdateResult($request, Student $student)
    {
        $subject_id = $request['subject_id'];
        $mark = $request['mark'];
        for ($i = 0; $i < count($subject_id); $i++) {
            $subject[$subject_id[$i]] = ['mark' => $mark[$i],
                'slug' => $student->id . '-' . $subject_id[$i] . '-' . $mark[$i]];
        }
        $student->results()->sync($subject);
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
        $result = $this->_model->where('student_id', '=', $id);
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
            $result = $this->_model->whereIn('subject_id', $id);
        } else {
            $result = $this->_model->where('subject_id', $id);
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
        $result = $this->_model->select('results.*', 'subjects.name')
            ->join('subjects', 'subjects.id', 'results.subject_id')
            ->where('student_id', '=', $id)->get();

        return $result;
    }

    public function getGPA($id)
    {
        $result = $this->_model->select(DB::raw(' AVG(mark) as GPA'))
            ->where('student_id', $id)
            ->groupBy('student_id')->first();
        return $result;
    }

    public function getResultQuantity()
    {
        $result = $this->_model->select('student_id', 'department_id', DB::raw('count(mark) as num_of_result'))
            ->join('students', 'students.id', 'results.student_id')
            ->groupBy('student_id', 'department_id')
            ->orderBy('student_id', 'asc')->get();
        return $result;
    }

    public function getBadStudent($complete_student)
    {
        $dismiss_student = $this->_model->select('student_id', DB::raw('avg(mark) as average_mark'))
            ->whereIn('student_id', $complete_student)
            ->groupBy('student_id')->having('average_mark', '<', 5)
            ->get();

        return $dismiss_student;
    }

    public function getStudentByMarkRange($from, $to)
    {
        $results = $this->_model->select('student_id')->where('mark', '>=', $from)->where('mark', '<=', $to)->distinct()->get();
        $student_id = [];
        foreach ($results as $result) {
            array_push($student_id, $result->student_id);
        }

        return $student_id;
    }

    public function enrollSubject($request)
    {
        $this->_model->create(['student_id' => $request['id'],
            'subject_id' => $request['name'],
            'mark' => 0
        ]);

    }

    public function deleteResultByStudentID($id)
    {
        return $this->_model->where('student_id', $id)->delete();
    }
}
