<?php

namespace App\Services;

use App\Http\Requests\CourseRequest;
use App\Interface\CourseInterface;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CourseService
{
    public $courseRepository;

    public function __construct(CourseInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function createCourse(CourseRequest $request)
    {

        $data = $request->validated();

        if ($request->hasFile('course_image')) {
            $data['course_image'] = Storage::putFile('courses', $request->file('course_image'));
        }

        $data['instructor_id'] = auth('instructor')->id();

        return $this->courseRepository->createCourse($data);
    }


    public function updateCourse($request, Course $course)
    {

        $data = $request->validated();
        $path  = $course->course_image;

        if ($request->hasFile('course_image')) {
            if (!empty($path) && Storage::exists($path)) {
                Storage::delete($path);
            }

            $path = Storage::putFile('courses', $request->file('course_image'));
        }
        $data['course_image'] = $path;
        return $this->courseRepository->updateCourse($data, $course);
    }
    public function deleteCourse(Course $course)
    {

            if (!empty($course->course_image) && Storage::exists($course->course_image)) {
                Storage::delete($course->course_image);
            }
            return $this->courseRepository->deleteCourse($course);

    }
}
