<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'subject_id', 'mark'];
    public $timestamps = true;

//    public function getSlugOptions(): SlugOptions
//    {
//        return SlugOptions::create()
//            ->generateSlugsFrom(['student_id', 'subject_id', 'mark'])
//            ->saveSlugsTo('slug');
//    }
//
//    public function getRouteKeyName(): string
//    {
//        return 'slug';
//    }
}
