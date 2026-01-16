<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

      public function lectures(){
        return $this->hasMany(CourseLecture::class, 'section_id', 'id');
    }

   

    
}
