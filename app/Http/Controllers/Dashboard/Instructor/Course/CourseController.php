<?php

namespace App\Http\Controllers\Dashboard\Instructor\Course;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CourseController extends Controller
{
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
    public function store(Request $request)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
