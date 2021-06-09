<?php

namespace Database\Factories;

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
        return [
            'student_id' => Student::pluck('id')->random(),
            'subject_id' => Subject::pluck('id')->random(),
            'mark' => $this->faker->randomFloat(2,0,10)
        ];
    }
}
