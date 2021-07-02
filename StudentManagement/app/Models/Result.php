<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'student_id', 'subject_id', 'mark'];
    public $timestamps = true;
    public function student()
    {
        return $this->belongsToMany(Student::class, 'student_id', 'id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
