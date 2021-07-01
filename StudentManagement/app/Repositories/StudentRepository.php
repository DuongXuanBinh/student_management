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

    public function filterStudent(Request $request, $result_per_student, $subject_per_department)
    {
        $age_from = $request->age_from;
        $age_to = $request->age_to;
        $this_year = Carbon::now()->format('Y');
        $from_year = $this_year - $age_from;
        $to_year = $this_year - $age_to;
        $mark_from = $request->mark_from;
        $mark_to = $request->mark_to;
        $mobile_network = $request->mobile_network;
        $students = Student::join('results', 'students.id', 'results.student_id')
            ->select('students.*')->where('results.mark', '>=', $mark_from)->where('results.mark', '<=', $mark_to)
            ->whereYear('students.birthday', '<=', $from_year)
            ->whereYear('students.birthday', '>=', $to_year)
            ->orderBy('students.id', 'ASC')->distinct()->get();
        if (count($request->status) < 2) {
            $status = $request->status[0];
            if ($status === 'complete') {
                $student_ID = $this->checkCompletion(1, $result_per_student, $subject_per_department);
                $students = $students->toQuery()->whereIn('students.id', $student_ID)->get();
            } else if ($status === 'in-progress') {
                $student_ID = $this->checkCompletion(2, $result_per_student, $subject_per_department);
                $students = $students->toQuery()->whereIn('students.id', $student_ID)->get();
            }
        }
        if (count($mobile_network) === 1) {
            if (in_array('viettel', $mobile_network)) {
                $students = $students->toQuery()->where('phone', 'regexp', '^09[3456]{1}[0-9]{7}$')->get();
            }
            if (in_array('vinaphone', $mobile_network)) {
                $students = $students->toQuery()->where('phone', 'regexp', '^09[012][0-9]{7}$')->get();
            }
            if (in_array('mobiphone', $mobile_network)) {
                $students = $students->toQuery()->where('phone', 'regexp', '^09[789][0-9]{7}$')->get();
            }
        } else {
            if (in_array('viettel', $mobile_network) && in_array('vinaphone', $mobile_network)) {
                $students = $students->toQuery()->orWhere('phone', 'regexp', '^09[3456]{1}[0-9]{7}$')->orWhere('phone', 'regexp', '^09[012][0-9]{7}$')->get();
            }
            if (in_array('vinaphone', $mobile_network) && in_array('mobiphone', $mobile_network)) {
                $students = $students->toQuery()->orWhere('phone', 'regexp', '^09[012][0-9]{7}$')->orWhere('phone', 'regexp', '^09[789][0-9]{7}$')->get();
            }
            if (in_array('mobiphone', $mobile_network) && in_array('vinaphone', $mobile_network)) {
                $students = $students->toQuery()->orWhere('phone', 'regexp', '^09[789][0-9]{7}$')->orWhere('phone', 'regexp', '^09[012][0-9]{7}$')->get();
            }
            if (in_array('mobiphone', $mobile_network) && in_array('viettel', $mobile_network)) {
                $students = $students->toQuery()->orWhere('phone', 'regexp', '^09[789][0-9]{7}$')->orWhere('phone', 'regexp', '^09[3456]{1}[0-9]{7}$')->get();
            }
        }

        return $students->toQuery()->paginate(50)->withQueryString();
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

}
