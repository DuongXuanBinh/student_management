<?php

namespace Tests\Unit\Repositories;

use App\Models\Student;
use PHPUnit\Framework\TestCase;

class StudentTest extends TestCase
{
    public function test_update_student()
    {
        $user = Student::factory()->makeOne();
    }
}
