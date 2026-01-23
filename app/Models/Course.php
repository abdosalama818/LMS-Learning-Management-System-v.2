<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Course extends Model
{
    protected $guarded = [];



    protected static function booted()
    {

        static::addGlobalScope('active', function ($query) {

            if (request()->is('/*') && auth('web')->check()) {
                $query->where('status', 1);
            }
        });


        static::saving(function ($course) {
            $course->course_name_slug = makeArabicSlug($course->course_name);
        });
        $clearCache = function () {
            Cache::forget(Category::CACHE_KEY_COURSES);
        };

        static::saved($clearCache);
        static::deleted($clearCache);
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id')->withDefault([
            'name' => 'N/A'
        ]);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id', 'id');
    }


    public function courseGoals()
    {
        return $this->hasMany(CourseGoal::class, 'course_id', 'id');
    }


    public function courseSections()
    {
        return $this->hasMany(CourseSection::class, 'course_id', 'id');
    }


    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student', 'course_id', 'student_id');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'course_id', 'id');
    }

    public function zoomMeetings()
    {
        return $this->hasMany(ZoomMeeting::class, 'course_id', 'id');
    }
}
