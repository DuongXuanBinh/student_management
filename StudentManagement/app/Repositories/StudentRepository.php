<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\Result;
use App\Models\Student;
use App\Models\Subject;
use App\Repositories\Repository_Interface\StudentRepositoryInterface;
use Carbon\Carbon;

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

    public function findStudentByAgeRange($from, $to)
    {
        $year = Carbon::now()->format('Y');
        $from_year = $year - $from;
        $to_year = $year - $to;
        $results = Student::whereYear('birthday','<=',$from_year)
            ->whereYear('birthday','>=',$to_year)->paginate(50);

        return $results;
    }

    public function findStudentByPhone($operator)
    {
        $results = array();
        $viettel = array('091','092','093');
        $vina = array('090','094','098');
        $mobi = array('095','096','097','099');

        if ($operator === 'Viettel') {
            for ($i = 0; $i < count($viettel); $i++){
                $viettel_users = Student::where('phone','LIKE',$viettel[$i].'%')->paginate(50);
                foreach ($viettel_users as $viettel_user)
                    array_push($results,$viettel_user);
            }
        }elseif ($operator === 'Vinaphone') {
            for ($i = 0; $i < count($vina); $i++){
                $vina_users = Student::where('phone','LIKE',$vina[$i].'%')->paginate(50);
                array_push($results,$vina_users);
            }
        }elseif ($operator === 'Mobiphone') {
            for ($i = 0; $i < count($mobi); $i++){
                $mobi_users = Student::where('phone','LIKE',$mobi[$i].'%')->paginate(50);
                array_push($results,$mobi_users);
            }
        }
        return $results;
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
                    array_push($check_complete,$students[$i]);
                }
            }
        }
        return $check_complete;
    }

    /**
     * Incomplete student
     * @return mixed|void
     */

    public function incompleteStudent()
    {
        $result = $this->checkCompletion(1);
        return $result;
    }

    public function completedStudent()
    {
        $result = $this->checkCompletion(2);
        return $result;
    }

    public function sendMailForDismiss()
    {

    }
}
