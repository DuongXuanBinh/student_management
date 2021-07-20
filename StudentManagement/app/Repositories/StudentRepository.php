<?php

namespace App\Repositories;

use App\Models\Student;
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
        if (array_key_exists('status', $data)) {
            if (count($data['status']) == 1) {
                if (in_array('complete', $data['status'])) {
                    $student_id = $this->checkCompletion(1);
                    $students->whereIn('id',$student_id);
                }elseif (in_array('in-progress', $data['status'])){
                    $student_id = $this->checkCompletion(2);
                    $students->whereIn('id',$student_id);
                }
            }
        }
        return $students->orderBy('students.id', 'ASC')->paginate(50)->withQueryString();
    }

    public function checkCompletion($type)
    {
        $student_id = [];
        $students = $this->_model->withCount('results')->with(['department' => function ($q) {
            $q->withCount('subjects');
        }])->get();
        foreach ($students as $student) {
            if ($type == 1 && $student->results_count == $student->department->subjects_count) {
                array_push($student_id, $student->id);
            } elseif ($type == 2 && $student->results_count < $student->department->subjects_count) {
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
