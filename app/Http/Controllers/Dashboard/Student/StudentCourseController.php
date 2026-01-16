<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLecture;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth('web')->user();
        $student = Student::where('user_id', $user->id)->where('status', 1)->with('courses')->first();
        if ($student) {
            $all_courses = $student->courses;
            return view('backend.user.course.index')->with('all_courses', $all_courses);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = auth('web')->user();
        $student = Student::where('user_id', $user->id)
            ->where('status', 1)
            ->first();

        if (!$student) {
            abort(403, "You are not enrolled in any course");
        }

        // جلب الكورس فقط لو الطالب مسجل فيه
        $course = $student->courses()
            ->with('courseSections')
            ->where('courses.id', $id)
            ->first();

        if (!$course) {
            abort(403, "You are not enrolled in this course");
        }


        return view('backend.user.course.showCourse')->with('course', $course);
    }



    public function showVideo( $lectureId)
{
    $user = auth('web')->user();
        $lecture = CourseLecture::with('section.course')->findOrFail($lectureId);
    
    // التأكد إن الطالب مسجل في الكورس
    $student = Student::where('user_id', $user->id)
        ->where('status', 1)
        ->firstOrFail();

    if (!$student->courses->contains($lecture->section->course_id)) {
        abort(403, 'You are not enrolled in this course.');
    }

// عرض الفيديو في صفحة iframe مع هيدرز حماية
return response()
    ->view('backend.user.course.video', [
        'lecture' => $lecture,
        'videoId' => youtubeEmbed($lecture->url),
    ])
    ->header('X-Frame-Options', 'SAMEORIGIN')
    ->header('Content-Security-Policy', "frame-src https://www.youtube.com");


    /* 
        // عرض الفيديو في صفحة iframe
    return view('backend.user.course.video', [
        'lecture' => $lecture,
        'videoId' => youtubeEmbed($lecture->url),
    ]);
    
    */
}



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
