<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'department_id', 'email', 'gender', 'birthday', 'address', 'phone'];
    public $timestamps = true;

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'results', 'student_id', 'subject_id')->withPivot('mark');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

}
