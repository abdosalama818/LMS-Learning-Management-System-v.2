<?php

namespace App\Http\Controllers\Dashboard\Instructor\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\SubCategory;
use App\Services\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public $courseService;
    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instructorId = auth()->guard('instructor')->user()->id;
        $all_courses = Course::where('instructor_id', $instructorId)->latest()->get();
        return view('backend.instructor.course.index', compact('all_courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $all_categories = Category::all();
        return view('backend.instructor.course.create')->with('all_categories', $all_categories);
    }

    public function getSubcategories( $categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)->get();

        return response()->json($subcategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        try {
            $this->courseService->createCourse($request);
            return redirect()->route('instructor.course.index')->with('success', 'Course created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $all_categories = Category::all();
        $course_goals = $course->courseGoals()->pluck('goal_name')->toArray();
        $all_subcategories = SubCategory::where('category_id', $course->category_id)->get();
        return view('backend.instructor.course.edit', compact('course', 'all_categories', 'all_subcategories', 'course_goals'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request,  Course $course)
    {
        try {
            $this->courseService->updateCourse($request, $course);
            return redirect()->route('instructor.course.index')->with('success', 'Course updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        try {
            $this->courseService->deleteCourse($course);
            return redirect()->route('instructor.course.index')->with('success', 'Course deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
