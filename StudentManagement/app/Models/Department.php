<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    public $timestamps = true;

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'subject_id', 'id');
    }
    public function students(){
        return $this->hasMany(Student::class, 'department_id', 'id');
    }
}
