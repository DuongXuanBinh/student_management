<?php

namespace Tests\Unit\Repositories;

use App\Models\Student;
use App\Repositories\StudentRepository;
use Faker\Factory;
use Tests\TestCase;

class StudentTest extends TestCase
{
    public function test_create_student()
    {
        $user = Student::factory()->make();
        $this->studentRepository = new StudentRepository();

        $new_user = $this->studentRepository->createNewStudent($user->toArray());
        $this->assertInstanceOf(Student::class, $new_user);
        $this->assertEquals($user['name'], $new_user->name);
        $this->assertEquals($user['department_id'], $new_user->department_id);
        $this->assertEquals($user['email'], $new_user->email);
        $this->assertEquals($user['gender'], $new_user->gender);
        $this->assertEquals($user['birthday'], $new_user->birthday);
        $this->assertEquals($user['address'], $new_user->address);
        $this->assertEquals($user['phone'], $new_user->phone);
    }

    public function test_check_student_has_finished()
    {
        $faker = Factory::create();
        $type = 1;
        $result_per_student = [];
        $num_of_subject = [];
        $expect = [];
        $this->studentRepository = new StudentRepository();
        for ($i = 0; $i < 50; $i++) {
            $result_per_student[$i] = [
                'student_id' => $faker->unique(true)->numberBetween(1,100),
                'department_id' => $faker->numberBetween(1,5),
                'num_of_result' => $faker->numberBetween(0, 10)
            ];
        }
        function cmp($a, $b): int
        {
            if($a['student_id'] == $b['student_id']){
                return 0;
            }
            return ($a['student_id'] < $b['student_id']) ? -1 : 1;
        }
        usort($result_per_student,"Tests\Unit\Repositories\cmp");
        for ($i = 0; $i < 5; $i++){
            $num_of_subject[$i] = [
                'department_id' =>  $faker->unique(true)->numberBetween(1,5),
                'num_of_subject' => $faker->numberBetween(5,10)
            ];
        }
        for($i = 0; $i < 50; $i++){
            for($j = 0; $j< 5; $j++){
                if($result_per_student[$i]['department_id']==$num_of_subject[$j]['department_id'] && $result_per_student[$i]['num_of_result']==$num_of_subject[$j]['num_of_subject']){
                    array_push($expect,$result_per_student[$i]['student_id']);
                }
            }
        }
        $complete  =  $this->studentRepository->checkCompletion($type);
        sort($expect);
        $this->assertEquals($expect,$complete);
    }

    public function test_get_studentid_by_email(){
        $faker = Factory::create();
        $this->studentRepository = new StudentRepository();
        $student = [
            'id' => 1,
            'name' => $faker->firstName,
            'department_id' => 4,
            'email' => $faker->email,
            'gender' => $faker->numberBetween(0,1),
            'birthday' => $faker->dateTimeBetween('-20 years','-15 years')->format('Y-m-d'),
            'address' => $faker->streetAddress,
            'phone' => $faker->regexify('09[0-9]{8}')
        ];
        $student_id = $student['id'];
        $result = $this->studentRepository->getDepartment($student_id);
        $this->assertEquals(4,$result['department_id']);
    }
}
