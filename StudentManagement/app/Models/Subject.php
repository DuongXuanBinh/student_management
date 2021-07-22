<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Subject extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['name', 'department_id', 'slug'];
    public $timestamps = true;

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function results()
    {
        return $this->belongsToMany(Student::class, 'results', 'subject_id', 'student_id')->withPivot('mark');
    }

    public function user()
    {
        return $this->hasOne(User::class);
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
