<?php

namespace App\Http\Controllers\Dashboard\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = Quiz::where('instructor_id', Auth::guard('instructor')->id())->latest()->get();
        return view('backend.instructor.quiz.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::where('instructor_id', Auth::guard('instructor')->id())->get();
        return view('backend.instructor.quiz.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'duration' => 'nullable|integer',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
        ]);

        $quiz = Quiz::create([
            'title' => $request->title,
            'description' => $request->description,
            'instructor_id' => Auth::guard('instructor')->id(),
            'course_id' => $request->course_id,
            'duration' => $request->duration,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
        ]);


        return redirect()->route('instructor.quiz.index')->with('success', 'Quiz created successfully');
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
        $quiz = Quiz::where('instructor_id', Auth::guard('instructor')->id())->findOrFail($id);
        $courses = Course::where('instructor_id', Auth::guard('instructor')->id())->get();

        return view('backend.instructor.quiz.edit', compact('quiz', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $quiz = Quiz::where('instructor_id', Auth::guard('instructor')->id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'duration' => 'nullable|integer',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
        ]);

        $quiz->update([
            'title' => $request->title,
            'description' => $request->description,
            'course_id' => $request->course_id,
            'duration' => $request->duration,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
        ]);

        return redirect()->route('instructor.quiz.index')->with('success', 'Quiz updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quiz = Quiz::where('instructor_id', Auth::guard('instructor')->id())->findOrFail($id);
        $quiz->delete();

        return redirect()->route('instructor.quiz.index')->with('success', 'Quiz deleted successfully');
    }

    public function attempts($id)
    {
        $quiz = Quiz::with('attempts.student')->where('instructor_id', Auth::guard('instructor')->id())->findOrFail($id);
        return view('backend.instructor.quiz.attempts', compact('quiz'));
    }
}
