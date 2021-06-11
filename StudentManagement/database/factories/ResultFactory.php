<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Result;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResultFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Result::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $student_id = Student::pluck('id')->random();
        $department_id = Student::where('id','=',$student_id)->first()->department_id;
        $subject_id = Subject::where('department_id','=',$department_id)->pluck('id')->random();

        return [
            'student_id' => $student_id,
            'subject_id' => $subject_id,
            'mark' => $this->faker->randomFloat(2,0,10)
        ];
    }
}
