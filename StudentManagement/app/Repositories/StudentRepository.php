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
            $studentID = $this->checkCompletion(1);
            $students = Student::whereIn('id', $studentID)->paginate(50)->withQueryString();
        } elseif ($type === 'in-progress') {
            $studentID = $this->checkCompletion(2);
            $students = Student::whereIn('id', $studentID)->paginate(50)->withQueryString();
        } elseif ($type === 'mobile-network') {
            if ($request->mobile_network === 'viettel') {
                $students = Student::where('phone', 'regexp', '^09[3456]{1}[0-9]{7}$')->paginate(50)->withQueryString();
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
        $check_complete = array();
        $result_of_student = Result::select('student_id', 'department_id', DB::raw('count(mark) as num_of_result'))
            ->join('students', 'students.id', 'results.student_id')
            ->groupBy('student_id', 'department_id')
            ->orderBy('student_id', 'asc')->get();
        $num_of_subject = Subject::select('department_id', DB::raw('count(*) as num_of_subject'))
            ->groupBy('department_id')->get();

        for ($i = 0; $i < count($result_of_student); $i++) {
            $department_id = $result_of_student[$i]->department_id;
            $num_of_result = $result_of_student[$i]->num_of_result;
            for ($j = 0; $j < count($num_of_subject); $j++) {
                if ($type == 1 && $department_id == $num_of_subject[$j]->department_id
                    && $num_of_result == $num_of_subject[$j]->num_of_subject) {
                    array_push($check_complete, $result_of_student[$i]->student_id);
                } elseif ($type == 2 && $department_id === $num_of_subject[$j]->department_id
                    && $num_of_result < $num_of_subject[$j]->num_of_subject) {
                    array_push($check_complete, $result_of_student[$i]->student_id);
                }
            }
        }
        return $check_complete;
    }


    public function sendMailForDismiss()
    {
        $check_complete = $this->checkCompletion(1);

        $dismiss_student = Result::select('student_id',DB::raw('avg(mark) as average_mark'))->whereIn('student_id',$check_complete)
            ->groupBy('student_id')
            ->get();
        dd($dismiss_student);
    }
}
