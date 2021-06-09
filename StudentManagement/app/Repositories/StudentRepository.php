<?php

namespace App\Repositories;

use App\Models\Student;
use App\Repositories\Repository_Interface\StudentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StudentRepository extends EloquentRepository implements StudentRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Student::class;
    }

    public function findStudentByAgeRange($from, $to)
    {
        $year = Carbon::now()->format('Y');
        $from_year = $year - $from;
        $to_year = $year - $to;
        $results = Student::whereYear('birthday','<=',$from_year)
            ->whereYear('birthday','>=',$to_year)->get();

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
                $viettel_users = Student::where('phone','LIKE',$viettel[$i].'%')->get();
                foreach ($viettel_users as $viettel_user)
                    array_push($results,$viettel_user);
            }
            dd($results);
//
        }elseif ($operator === 'Vinaphone') {
            for ($i = 0; $i < count($vina); $i++){
                $vina_users = Student::where('phone','LIKE',$vina[$i].'%')->get();
                array_push($results,$vina_users);
            }
            dd($results);
        }elseif ($operator === 'Mobiphone') {
            for ($i = 0; $i < count($mobi); $i++){
                $mobi_users = Student::where('phone','LIKE',$mobi[$i].'%')->get();
                array_push($results,$mobi_users);
            }
            dd($results);
        }
        return $results;





    }

    public function incompleteStudent()
    {
        // TODO: Implement incompleteStudent() method.
    }

    public function completedStudent()
    {
        // TODO: Implement completedStudent() method.
    }

    public function addStudent($array)
    {
        // TODO: Implement addStudent() method.
    }

    public function sendMailForDismiss()
    {
        // TODO: Implement sendMailForDismiss() method.
    }

    public function updateProfile()
    {
        // TODO: Implement updateProfile() method.
    }
}
