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
        $current_year = Carbon::now('Asia/Ho_Chi_Minh')->format('Y');
        $students = $this->_model->with(['department' => function ($query) {
            $query->select('id', 'name');
        }]);

        if (array_key_exists('age_from', $data) && !is_null($data['age_from'])) {
            $students->whereYear('students.birthday', '<=', $current_year - $data['age_from']);
        }

        if (isset($data['age_to']) && !is_null($data['age_to'])) {
            $students->whereYear('students.birthday', '>=', $current_year - $data['age_to']);
        }

        if (array_key_exists('mark_from', $data) && !is_null($data['mark_from'])
            || array_key_exists('mark_to', $data) && !is_null($data['mark_to'])) {
            $students->whereHas('subjects', function ($q) use ($data) {
                if (!empty($data['mark_from'])) {
                    $q->where('mark', '>=', $data['mark_from']);
                }
                if (!empty($data['mark_to'])) {
                    $q->where('mark', '<=', $data['mark_to']);
                }
            });
        }

        if (array_key_exists('mobile_network', $data)) {
            $students->where(function ($q) use ($data) {
                if (in_array('viettel', $data['mobile_network'])) {
                    $q->orWhere('phone', 'regexp', VIETTEL);
                }
                if (in_array('vinaphone', $data['mobile_network'])) {
                    $q->orWhere('phone', 'regexp', VINAPHONE);
                }
                if (in_array('mobiphone', $data['mobile_network'])) {
                    $q->orWhere('phone', 'regexp', MOBIPHONE);
                }
            });
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

        return $students->orderBy('students.id', 'ASC')->paginate(30)->withQueryString();
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

    public function deleteDepartmentStudent($department_id)
    {
        $result = $this->_model->where('department_id', $department_id);
        $result->delete();
    }

    public function getUser($department_id)
    {
        return $this->_model->select('user_id')->where('department_id', $department_id)->get()->pluck('user_id')->toArray();
    }

    public function checkUserByMail($email)
    {
        return $this->_model->where('email', $email)->first();
    }

    public function enrollSubject($request)
    {
        $this->_model->subjects()->attach($request['subject_id'],
            ['student_id' => $request['id'],
                'mark' => 0,
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                'updated_at' => Carbon::now('Asia/Ho_Chi_Minh')]);
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

    public function deleteResults($department_id, $subject_ids)
    {
        $students = $this->_model->where('department_id', $department_id)->get();

        foreach ($students as $student) {
            $student->subjects()->detach($subject_ids);
        }
    }

    public function getResultByStudentID($id)
    {
        return $this->findByID($id)->subjects()->orderBy('results.id', 'asc')->get();
    }

    public function getIDByMail($email)
    {
        return $this->_model->where('email', $email)->firstOrFail()->id;
    }

    public function getGPA($id)
    {
        $student = $this->findByID($id);

        return $student->subjects->avg('mark');
    }

    public function getBadStudent()
    {
        return $this->_model->whereHas('subjects', function ($q) {
            $q->select('*', DB::raw('avg(mark) as average_mark'))
                ->whereIn('student_id', $this->checkCompletion(1))
                ->groupBy('student_id')->having('average_mark', '<', 5);
        })->get()->pluck('id')->toArray();
    }

    public function deleteStudentResult($id)
    {
        $student = $this->findByID($id);
        $student->subjects()->sync([]);
    }
}
