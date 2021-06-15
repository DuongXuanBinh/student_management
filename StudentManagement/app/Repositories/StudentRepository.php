<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\Result;
use App\Models\Student;
use App\Models\Subject;
use App\Repositories\Repository_Interface\StudentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

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

    public function filterStudent(Request $request)
    {
        $type = $request->type;
        $from = $request->from;
        $to = $request->to;
        $students = [];
        if ($type === 'age-range') {
            $this_year = Carbon::now()->format('Y');
            $from_year = $this_year - $from;
            $to_year = $this_year - $to;
            $students = Student::whereYear('birthday', '<=', $from_year)
                ->whereYear('birthday', '>=', $to_year)->paginate(50)->withQueryString();
        } elseif ($type === 'mark-range') {
            $students = Student::join('results', 'students.id', 'results.student_id')
                ->select('students.*')->where('results.mark', '>=', $from)->where('results.mark', '<=', $to)
                ->orderBy('students.id', 'ASC')->paginate(50)->withQueryString();
        } elseif ($type === 'complete') {

        } elseif ($type === 'in-progress') {

        } elseif ($type === 'mobile-network') {
            if ($request->mobile_network === 'viettel') {
                $students = Student::where('phone', 'regexp','^09[3456]{1}[0-9]{7}$')->paginate(50)->withQueryString();
            } elseif ($request->mobile_network === 'vinaphone') {
                $students = Student::where('phone', 'regexp', '^09[012][0-9]{7}$')->paginate(50)->withQueryString();
            } elseif ($request->mobile_network === 'mobiphone') {
                $students = Student::where('phone', 'regexp', '^09[789][0-9]{7}$')->paginate(50)->withQueryString();
            }
        }
        return $students;
    }


    /**Function to check student's completion
     * $type = 1 => incomplete or 2 => completed
     * @param $type
     * @return array
     */
    public function checkCompletion($type)
    {
        $students = Student::all();
        $departments = Department::all('id');
        $number_of_subjects = array();
        $check_complete = array();

        for ($i = 0; $i < count($departments); $i++) {
            $amount = count(Subject::where('department_id', '=', $departments[$i]->id)->get());
            array_push($number_of_subjects, $amount);
        }

        for ($i = 0; $i < count($students); $i++) {
            $result = count(Result::where('student_id', '=', $students[$i]->id)->get());
            $student_department = $students[$i]->department_id;
            for ($j = 0; $j < count($departments); $j++) {
                if ($type == 1 && $student_department == $departments[$j]->id && $result < $number_of_subjects[$j]) {
                    array_push($check_complete, $students[$i]);
                } elseif ($type == 2 && $student_department == $departments[$j]->id && $result == $number_of_subjects[$j]) {
                    array_push($check_complete, $students[$i]);
                }
            }
        }
        return $check_complete;
    }


    public function sendMailForDismiss()
    {

    }
}
