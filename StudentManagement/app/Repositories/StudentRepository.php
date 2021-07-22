<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface\StudentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StudentRepository extends EloquentRepository implements StudentRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Student::class;
    }

    public function filterStudent($data)
    {
        $current_year = Carbon::now()->format('Y');
        $students = $this->_model->with(['department' => function ($query) {
            $query->select('id', 'name');
        }]);

        if (array_key_exists('age_from', $data) && !is_null($data['age_from'])) {
            $students->whereYear('students.birthday', '<=', $current_year - $data['age_from']);
        }

        if (array_key_exists('age_to', $data) && !is_null($data['age_to'])) {
            $students->whereYear('students.birthday', '>=', $current_year - $data['age_to']);
        }
        if (array_key_exists('mark_from', $data) && !is_null($data['mark_from'])) {
            $students->whereHas('subjects', function ($q) use ($data) {
                $q->where('mark', '>=', $data['mark_from']);
            });
        }
        if (array_key_exists('mark_to', $data) && !is_null($data['mark_to'])) {
            $students->whereHas('subjects', function ($q) use ($data) {
                $q->where('mark', '>=', $data['mark_to']);
            });
        }
        if (array_key_exists('mobile_network', $data)) {
            if (count($data['mobile_network']) == 1) {
                if (in_array('viettel', $data['mobile_network'])) {
                    $students->where('phone', 'regexp', '^09[3456]{1}[0-9]{7}$');
                } elseif (in_array('vinaphone', $data['mobile_network'])) {
                    $students->where('phone', 'regexp', '^09[012]{1}[0-9]{7}$');
                } elseif (in_array('mobiphone', $data['mobile_network'])) {
                    $students->where('phone', 'regexp', '^09[789]{1}[0-9]{7}$');
                }
            } else {
                if (!in_array('viettel', $data['mobile_network'])) {
                    $students->where('phone', 'regexp', '^09[012]{1}[0-9]{7}$')->orWhere('phone', 'regexp', '^09[789]{1}[0-9]{7}$');
                } elseif (!in_array('vinaphone', $data['mobile_network'])) {
                    $students->where('phone', 'regexp', '^09[3456]{1}[0-9]{7}$')->orWhere('phone', 'regexp', '^09[789]{1}[0-9]{7}$');
                } elseif (!in_array('mobiphone', $data['mobile_network'])) {
                    $students->where('phone', 'regexp', '^09[3456]{1}[0-9]{7}$')->orWhere('phone', 'regexp', '^09[012]{1}[0-9]{7}$');
                }
            }
        }
        if (array_key_exists('status', $data) && count($data['status']) == 1) {
            if (in_array('complete', $data['status'])) {
                $student_id = $this->checkCompletion(1);
                $students->whereIn('id', $student_id);
            } elseif (in_array('in-progress', $data['status'])) {
                $student_id = $this->checkCompletion(2);
                $students->whereIn('id', $student_id);
            }
        }
        return $students->orderBy('students.id', 'ASC')->paginate(50)->withQueryString();
    }

    public function checkCompletion($type)
    {
        $student_id = [];
        $students = $this->_model->with('subjects')->withCount('subjects')->with(['department' => function ($q) {
            $q->withCount('subjects');
        }])->get();

        foreach ($students as $student) {
            if ($type == 1 && $student->subjects_count == $student->department->subjects_count) {
                array_push($student_id, $student->id);
            } elseif ($type == 2 && $student->subjects_count < $student->department->subjects_count) {
                array_push($student_id, $student->id);
            }
        }
        return $student_id;
    }

    public function getStudentIDToDismiss($dismiss_student)
    {
        $student_id = [];
        for ($i = 0; $i < count($dismiss_student); $i++) {
            $id = $dismiss_student[$i]->student_id;
            array_push($student_id, $id);
        }
        return $student_id;
    }

    public function deleteDepartmentStudent($department_id)
    {
        $result = $this->_model->where('department_id', $department_id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    public function getStudent($department_id)
    {
        $student_id = [];
        $students = $this->_model->where('department_id', $department_id)->get();
        for ($i = 0; $i < count($students); $i++) {
            array_push($student_id, $students[$i]->id);
        }
        return $student_id;
    }

    public function getDepartment($student_id)
    {
        return $this->findByID($student_id)->department();
    }

    public function getIDByMail($email)
    {
        return $this->_model->select('id')->where('email', $email)->first()->id;
    }

    public function enrollSubject($request)
    {
        $this->_model->subjects()->attach($request['subject_id'],
            ['student_id' => $request['id'],
                'mark' => 0]);
    }

    public function massiveUpdateResult($request, $student_id)
    {
        $subject = [];
        $student = $this->findByID($student_id);
        if (isset($request['mark'])) {
            $mark = $request['mark'];
            $subject_ids = $request['subject_id'];

            foreach ($subject_ids as $key => $subject_id) {
                $subject[$subject_id] = ['mark' => $mark[$key]];
            }
        }
        $student->subjects()->sync($subject);

        return $student->subjects;
    }

    public function deleteSubject($ids)
    {
        return $this->_model->subjects()->detach($ids);
    }

    public function getResultByStudentID($id)
    {
        $student = $this->findByID($id);
        return $student->with('subjects');
    }

    public function getGPA($id)
    {
        $student = $this->findByID($id);
        return $student->with(['subjects' => function ($q) {
            $q->select(DB::raw('avg(mark) as GPA'));
        }]);
    }

    public function getBadStudent()
    {
        return $this->_model->with(['subjects' => function ($q) {
            $q->select('student_id', DB::raw('avg(mark) as average_mark'))
                ->whereIn('student_id', $this->checkCompletion(1))
                ->groupBy('student_id')->having('average_mark', '<', 5);
        }])->get();
    }

    public function deleteStudentResult($id)
    {
        $student = $this->findByID($id);
        $student->subjects()->sync([]);
    }

    public function getResult()
    {
        return $this->_model->with(['subjects' => function ($q) {
            $q->select('results.id', 'subject_id','mark');
        }])->paginate(50);
    }
}
