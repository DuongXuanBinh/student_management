<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Department extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['name', 'slug'];
    public $timestamps = true;

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'department_id', 'id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'department_id', 'id');
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
