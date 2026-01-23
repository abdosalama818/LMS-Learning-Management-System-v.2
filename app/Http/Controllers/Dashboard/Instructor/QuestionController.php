<?php

namespace App\Http\Controllers\Dashboard\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($quiz_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);
        $questions = Question::where('quiz_id', $quiz_id)->latest()->get();
        return view('backend.instructor.question.index', compact('questions', 'quiz'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($quiz_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);
        return view('backend.instructor.question.create', compact('quiz'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
  $request->validate([
        'quiz_id' => 'required|exists:quizzes,id',

        'questions' => 'required|array|min:1',

        'questions.*.question' => 'required|string|min:5',

        'questions.*.option_a' => 'required|string|min:1',
        'questions.*.option_b' => 'required|string|min:1',
        'questions.*.option_c' => 'required|string|min:1',
        'questions.*.option_d' => 'required|string|min:1',

        'questions.*.answer' => 'required|in:option_a,option_b,option_c,option_d',
    ]);
        $quiz_id = $request->quiz_id;
        $questions = $request->questions; // Assume array of questions

        foreach ($questions as $q) {
            Question::create([
                'quiz_id' => $quiz_id,
                'question' => $q['question'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'answer' => $q['answer'],
            ]);
        }

        return redirect()->route('instructor.question.index', $request->quiz_id)->with('success', 'Questions created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $question = Question::findOrFail($id);
        return view('backend.instructor.question.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'answer' => 'required|string',
        ]);

        $question->update([
            'question' => $request->question,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'answer' => $request->answer,
        ]);

        return redirect()->route('instructor.question.index', $question->quiz_id)->with('success', 'Question updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $quiz_id = $question->quiz_id;
        $question->delete();

        return redirect()->route('instructor.question.index', $quiz_id)->with('success', 'Question deleted successfully');
    }
}
