<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
   protected $guarded = [];

protected static function booted()
{
    static::creating(function ($course) {
        $course->course_name_slug = Str::slug($course->course_name, '-');
    });
}

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id', 'id');
    }



}
