<?php

namespace Tests\Unit\Repositories;

use App\Models\Student;
use App\Models\Subject;
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
        $this->assertInstanceOf(Student::class,$new_user);
        $this->assertEquals($user['name'],$new_user->name);
        $this->assertEquals($user['department_id'],$new_user->department_id);
        $this->assertEquals($user['email'],$new_user->email);
        $this->assertEquals($user['gender'],$new_user->gender);
        $this->assertEquals($user['birthday'],$new_user->birthday);
        $this->assertEquals($user['address'],$new_user->address);
        $this->assertEquals($user['phone'],$new_user->phone);
    }

    public function test_check_student_has_finished()
    {
        $faker = Factory::create();
        $data = [];
        for($i = 0; $i < 100; $i++){
            $student_id = Student::pluck('id')->random();
            $department_id = Student::where('id','=',$student_id)->first()->department_id;
            $num_of_result = Subject::where('department_id',$department_id)->count();
            $num = rand(0,$num_of_result);
            $data[$i] = [
                'student_id' => $student_id,
                'department_id' => $department_id,
                'num_of_result' => $faker->numberBetween(0,$num)
            ];
        }


    }
}
