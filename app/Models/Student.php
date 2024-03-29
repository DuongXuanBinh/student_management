<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['user_id', 'name', 'department_id', 'email', 'gender', 'birthday', 'address', 'phone', 'slug'];
    public $timestamps = true;

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'results', 'student_id', 'subject_id')->withPivot('mark as mark');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

}
