<?php

namespace App\Http\Controllers\Dashboard\Instructor\Course;

use \App\Services\SectionServices;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSection;
use Illuminate\Http\Request;

class CourseSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request , SectionServices $sectionServices)
    {
        try {
            $section = $sectionServices->storeSection($request);
            return redirect()->back()->with('success', 'Course section created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the course section: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::findOrFail($id);
         $course_wise_lecture = $course->courseSections()->with('lectures')->get();
        return view('backend.instructor.course-section.index', compact('course', 'course_wise_lecture'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
    public function destroy(string $id , SectionServices $sectionServices)
    {
        try {
            $sectionServices->deleteSection($id);
            return redirect()->back()->with('success', 'Course section deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the course section: ' . $e->getMessage());
        }
    }
}
