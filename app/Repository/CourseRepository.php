<?php

namespace App\Repository;

use \App\Interface\CourseInterface;
use App\Models\Course;
use App\Models\CourseGoal;
use Illuminate\Support\Facades\DB;

class CourseRepository implements CourseInterface
{
    public function createCourse($data)
    {  
        DB::beginTransaction();
        try {
            $course_goals = $data['course_goals'] ?? []; 
            unset($data['course_goals']);
            $course = Course::create($data);
            if (isset($course_goals) && is_array($course_goals)) {
                $itemGoals = [];
                foreach ($course_goals as $goal) {
                    $itemGoals[] = ['goal_name' => $goal, 'course_id' => $course->id   ];
                }
              $course->courseGoals()->insert($itemGoals);
            }
            DB::commit();
            return $course;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public function updateCourse($data,Course $course)
    {
        DB::beginTransaction();
        try{
            $course_goals = $data['course_goals'] ?? []; 
            unset($data['course_goals']);
            $course->update($data);
            if (isset($course_goals) && is_array($course_goals)) {
              
                // Delete existing goals
                CourseGoal::where('course_id', $course->id)->delete();
                $itemGoals = [];
                foreach ($course_goals as $goal) {
                    $itemGoals[] = ['goal_name' => $goal, 'course_id' => $course->id   ];
                }
              $course->courseGoals()->insert($itemGoals);
            }
            DB::commit();
            return $course; 

        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
    } 
}

    public function deleteCourse(Course $course) {
        return $course->delete();
    }
}