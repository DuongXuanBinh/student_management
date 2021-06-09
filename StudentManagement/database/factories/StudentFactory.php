<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'department_id' => Department::pluck('id')->random(),
            'email' => $this->faker->email,
            'gender' => $this->faker->numberBetween(0,1),
            'birthday' => $this->faker->dateTimeBetween('-20 years','-15 years')->format('Y-m-d'),
            'address' => $this->faker->streetAddress,
            'phone' => $this->faker->regexify('09[0-9]{8}')
        ];
    }
}
