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
        return $this->_model->select('results.*', 'subjects.name')
            ->join('subjects', 'subjects.id', 'results.subject_id')
            ->where('student_id', '=', $id)->get();
    }

    public function getGPA($id)
    {
        return $this->_model->select(DB::raw(' AVG(mark) as GPA'))
            ->where('student_id', $id)
            ->groupBy('student_id')->first();
    }

    public function getBadStudent($complete_student)
    {
        return $this->_model->select('student_id', DB::raw('avg(mark) as average_mark'))
            ->whereIn('student_id', $complete_student)
            ->groupBy('student_id')->having('average_mark', '<', 5)
            ->get();
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
