<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentQuizController extends Controller
{
    public function index($course_id)
    {
        $user = Auth::guard('web')->user();
        $student = Student::where('user_id', $user->id)->first();

        // Check enrollment
        if (!$student || !$student->courses->contains($course_id)) {
            abort(403, 'You are not enrolled in this course.');
        }

        $course = Course::findOrFail($course_id);
        $quizzes = Quiz::where('course_id', $course_id)->get();

        return view('frontend.student.quiz.index', compact('course', 'quizzes'));
    }

    public function show($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        $user = Auth::guard('web')->user();
        $student = Student::where('user_id', $user->id)->first();

        // Check enrollment (via course)
        if (!$student || !$student->courses->contains($quiz->course_id)) {
            abort(403, 'You are not enrolled in the course this quiz belongs to.');
        }

        // Check if student has already attempted using property naming standard
        // Relationship in Student model is quizAttempts, but we can also check via course or direct query if needed.
        // Assuming relationship is defined as 'attempts' in Quiz or 'quizAttempts' in Student.
        // Let's use the relationship we added to Quiz model: attempts()
        $existingAttempt = $quiz->attempts()->where('student_id', $student->id)->exists();
        if ($existingAttempt) {
            return redirect()->back()->with('error', 'You have already attempted this quiz.');
        }

        // Check Time Window
        $now = now();
        if ($quiz->start_at && $now->lt($quiz->start_at)) {
            return redirect()->back()->with('error', 'This quiz has not started yet.');
        }
        if ($quiz->end_at && $now->gt($quiz->end_at)) {
            return redirect()->back()->with('error', 'This quiz has expired.');
        }

        return view('frontend.student.quiz.take_quiz', compact('quiz'));
    }

    public function submit(Request $request, $id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        $user = Auth::guard('web')->user();
        $student = Student::where('user_id', $user->id)->first();

        // Security Check: Enrollment
        if (!$student || !$student->courses->contains($quiz->course_id)) {
            abort(403, 'You are not enrolled in the course this quiz belongs to.');
        }

        // Security Check: Single Attempt
        $existingAttempt = $quiz->attempts()->where('student_id', $student->id)->exists();
        if ($existingAttempt) {
            abort(403, 'You have already attempted this quiz.');
        }

        // Security Check: Time Window
        $now = now();
        if (($quiz->start_at && $now->lt($quiz->start_at)) || ($quiz->end_at && $now->gt($quiz->end_at))) {
            abort(403, 'Quiz submission period is not active.');
        }

        $questions = $quiz->questions;
        $total_questions = $questions->count();
        $correct_answers = 0;

        foreach ($questions as $question) {
            $submitted_answer = $request->input('q_' . $question->id);
            if ($submitted_answer == $question->answer) {
                $correct_answers++;
            }
        }

        $score = ($total_questions > 0) ? ($correct_answers / $total_questions) * 100 : 0;

        // Save Attempt
        $attempt = \App\Models\QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'student_id' => $student->id,
            'total_questions' => $total_questions,
            'correct_answers' => $correct_answers,
            'score' => $score,
        ]);

        $percentage = $score; // For view compatibility

        return view('frontend.student.quiz.result', compact('quiz', 'score', 'total_questions', 'correct_answers', 'percentage'));
    }

    public function myQuizzes()
    {
        $user = Auth::guard('web')->user();
        $student = Student::where('user_id', $user->id)->first();

        if (!$student) {
            abort(403, 'You are not valid student.');
        }

        // Get all quizzes from all enrolled courses
        $quizzes = Quiz::whereIn('course_id', $student->courses->pluck('id'))->with('course')->get();

        return view('frontend.student.quiz.my_quizzes', compact('quizzes'));
    }
}
