<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface\StudentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentRepository extends EloquentRepository implements StudentRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Student::class;
    }

    public function index(array $data)
    {
        return $this->filterStudent($data);
    }

    public function createNewStudent(array $attribute)
    {
        return parent::create($attribute);
    }

    public function deleteStudent($slug)
    {
        return parent::delete($slug);
    }

    public function updateStudent($slug, array $attribute)
    {
        return parent::update($slug, $attribute);
    }

    public function findStudent($slug)
    {
        return parent::find($slug);
    }

    public function filterStudent($data)
    {
        $current_year = Carbon::now()->format('Y');
        $students = $this->_model->with(['department' => function ($query) {
            $query->select('id', 'name');
        }]);
        if (array_key_exists('age_from', $data)) {
            if (!is_null($data['age_from'])) {
                $students->whereYear('students.birthday', '<=', $current_year - $data['age_from']);
            }
        }
        if (array_key_exists('age_to', $data)) {
            if (!is_null($data['age_to'])) {
                $students->whereYear('students.birthday', '>=', $current_year - $data['age_to']);
            }
        }
        if (array_key_exists('mark_from', $data)) {
            if (!is_null($data['mark_from'])) {
                $students->whereHas('department', function ($q) use ($data) {
                    $q->whereHas('subjects', function ($q) use ($data) {
                        $q->whereHas('results', function ($q) use ($data) {
                            $q->where('mark', '>=', $data['mark_from']);
                        });
                    });
                });
            }
        }
        if (array_key_exists('mark_to', $data)) {
            if (!is_null($data['mark_to'])) {
                $students->whereHas('department', function ($q) use ($data) {
                    $q->whereHas('subjects', function ($q) use ($data) {
                        $q->whereHas('results', function ($q) use ($data) {
                            $q->where('mark', '>=', $data['mark_to']);
                        });
                    });
                });
            }
        }
//        if(array_key_exists('mark_to',$data)){
//            $students->whereHas('department')->whereHas('subjects')->whereHas('results')->where('mark','>=',$data['mark_to']);
//        }
//            ->whereIn('students.id', $student_by_mark)
//            ->whereYear('students.birthday', '>=', $to_year)
//            ->where(function ($query) use ($mobile_network) {
//                for ($i = 0; $i < count($mobile_network); $i++) {
//                    if ($i > 0) {
//                        $query->orWhere('students.phone', 'regexp', $mobile_network[$i]);
//                    } else {
//                        $query->where('students.phone', 'regexp', $mobile_network[$i]);
//                    }
//                }
//            })
//            ->where(function ($query) use ($status, $complete, $in_progress) {
//                if (count($status) === 1) {
//                    if ($status[0] == 1) {
//                        $query->whereIn('students.id', $complete);
//                    } else {
//                        $query->whereIn('students.id', $in_progress);
//                    }
//                }
//
//            })

        return $students->orderBy('students.id', 'ASC')->paginate(50)->withQueryString();
    }


    /**Function to check student's completion
     * $type = 1 => completed or 2 => incomplete
     * @param $type
     * @param $result_of_student
     * @param $num_of_subject
     * @return array
     */
    public function checkCompletion($type, $result_of_student, $num_of_subject)
    {
        $check_complete = [];
        for ($i = 0; $i < count($result_of_student); $i++) {
            $department_id = $result_of_student[$i]['department_id'];
            $num_of_result = $result_of_student[$i]['num_of_result'];
            for ($j = 0; $j < count($num_of_subject); $j++) {
                if ($type == 1 && $department_id == $num_of_subject[$j]['department_id'] && $num_of_result == $num_of_subject[$j]['num_of_subject']) {
                    array_push($check_complete, $result_of_student[$i]['student_id']);
                } elseif ($type == 2 && $department_id == $num_of_subject[$j]['department_id'] && $num_of_result < $num_of_subject[$j]['num_of_subject']) {
                    array_push($check_complete, $result_of_student[$i]['student_id']);
                }
            }
        }
        return $check_complete;
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
        $department_id = $this->_model->select('department_id')->where('id', $student_id)->first();
        return $department_id;
    }

    public function getIDByMail($email)
    {
        $student_id = $this->_model->select('id')->where('email', $email)->first()->id;

        return $student_id;
    }

    public function findStudentByID($id)
    {
        return $this->_model->where('id', $id)->firstOrFail();
    }

}
