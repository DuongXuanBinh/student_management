<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'department_id','email','gender','birthday','address','phone'];
    public $timestamps = true;

    public function results(){
        return $this->hasMany(Result::class,'student_id','id');
    }

    public function department(){
        return $this->belongsTo(Deparment::class,'id','department_id');
    }
}
