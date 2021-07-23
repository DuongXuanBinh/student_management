<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = Student::factory()->count(200)->create();
        foreach ($students as $student) {
            repeat:
            try {
                $student->save();
            } catch (QueryException $e) {
                $student = Student::factory()->make();
                goto repeat;
            }
        }
    }
}
