<?php

namespace App\Repositories;

use App\Models\Student;
use App\Repositories\RepositoryInterface\StudentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;


class StudentRepository extends EloquentRepository implements StudentRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Student::class;
    }

    public function index()
    {
        return parent::getAll();
    }

    public function createNewStudent(array $attribute)
    {
        return parent::create($attribute);
    }

    public function deleteStudent($id)
    {
        return parent::delete($id);
    }

    public function updateStudent($id, array $attribute)
    {
        return parent::update($id, $attribute);
    }

    public function findStudentById($id)
    {
        return parent::find($id);
    }

    public function filterStudent(Request $request, $result_per_student, $subject_per_department, $student_by_mark)
    {
        $age_from = $request->age_from;
        $age_to = $request->age_to;
        $this_year = Carbon::now()->format('Y');
        $from_year = $this_year - $age_from;
        $to_year = $this_year - $age_to;
        $mobile_network = $request->mobile_network;
        $status = $request->status;
        $complete = $this->checkCompletion(1, $result_per_student, $subject_per_department);
        $in_progress = $this->checkCompletion(2, $result_per_student, $subject_per_department);
        $students = Student::whereIn('id', $student_by_mark)
            ->whereYear('birthday', '<=', $from_year)
            ->whereYear('birthday', '>=', $to_year)
            ->when($mobile_network, function ($query) use ($mobile_network) {
                for ($i = 0; $i < count($mobile_network); $i++) {
                    if ($i > 0) {
                        $query->orWhere('phone', 'regexp', $mobile_network[$i]);
                    } else {
                        $query->where('phone', 'regexp', $mobile_network[$i]);
                    }
                }
            })
            ->when(count($status) == 1, function ($query) use ($status, $complete, $in_progress) {
                if ($status[0] == 1) {
                    $query->whereIn('id', $complete);
                } else {
                    $query->whereIn('id', $in_progress);
                }
            })
            ->orderBy('id', 'ASC')->paginate(50)->withQueryString();
        if (count($students) == 0) {
            return false;
        } else {
            return $students;
        }
    }


    /**Function to check student's completion
     * $type = 1 => completed or 2 => incomplete
     * @param $type
     * @return array
     */
    public function checkCompletion($type, $result_of_student, $num_of_subject)
    {
        $check_complete = array();
        for ($i = 0; $i < count($result_of_student); $i++) {
            $department_id = $result_of_student[$i]->department_id;
            $num_of_result = $result_of_student[$i]->num_of_result;
            for ($j = 0; $j < count($num_of_subject); $j++) {
                if ($type == 1 && $department_id == $num_of_subject[$j]->department_id && $num_of_result == $num_of_subject[$j]->num_of_subject) {
                    array_push($check_complete, $result_of_student[$i]->student_id);
                } elseif ($type == 2 && $department_id === $num_of_subject[$j]->department_id && $num_of_result < $num_of_subject[$j]->num_of_subject) {
                    array_push($check_complete, $result_of_student[$i]->student_id);
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

    public function deleteDepartmentStudent($id)
    {
        $result = Student::where('department_id', $id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    public function getStudent($department_id)
    {
        $student_id = [];
        $students = Student::where('department_id', $department_id)->get();
        for ($i = 0; $i < count($students); $i++) {
            array_push($student_id, $students[$i]->id);
        }
        return $student_id;
    }

    public function getDepartment($student_id)
    {
        $department_id = Student::select('department_id')->where('id',$student_id)->first();

        return $department_id;
    }

}
