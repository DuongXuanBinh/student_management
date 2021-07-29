<?php

namespace Database\Seeders;

use App\Models\Result;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;

class ResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $results = Result::factory()->count(1000)->make();
        foreach ($results as $result) {
            repeat:
            try {
                $result->save();
            } catch (QueryException $e) {
                $result = Result::factory()->make();
                goto repeat;
            }
        }
    }
}
