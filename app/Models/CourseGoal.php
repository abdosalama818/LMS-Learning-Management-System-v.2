<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseGoal extends Model
{
    protected $fillable = [
        'goal_name',
        'course_id',
    ]; 


    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
