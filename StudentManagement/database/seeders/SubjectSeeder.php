<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = Subject::factory()->count(10)->make();
    }
}
