<?php

namespace App\Interface;

use App\Models\Course;

interface CourseInterface
{
    public function createCourse($request);
    public function updateCourse($request,Course $course);
    public function deleteCourse(Course $course);
}
