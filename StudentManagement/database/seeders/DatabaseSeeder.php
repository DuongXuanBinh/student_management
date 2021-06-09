<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(DepartmentSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(ResultSeeder::class);
    }
}
