<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'department_id'];
    public $timestamps = true;

    public function department(){
        return $this->belongsTo(Deparment::class, 'department_id', 'id');
    }
    public function results(){
        return $this->hasMany(Result::class, 'subject_id', 'id');
    }
}
