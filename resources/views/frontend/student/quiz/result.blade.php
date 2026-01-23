@extends('backend.user.master')

@section('content')
    <div class="page-content">
        <div class="card">
            <div class="card-body text-center p-5">
                <h3 class="mb-4">Quiz Results: {{ $quiz->title }}</h3>

                <div class="mb-4">
                    <div style="font-size: 4rem; font-weight: bold; color: {{ $percentage >= 50 ? 'green' : 'red' }}">
                        {{ round($percentage, 1) }}%
                    </div>
                    <p class="text-muted">You scored {{ $score }} out of {{ $total_questions }}</p>
                </div>

                @if ($percentage >= 50)
                    <div class="alert alert-success d-inline-block">
                        Congratulations! You passed the quiz.
                    </div>
                @else
                    <div class="alert alert-danger d-inline-block">
                        Unfortunately, you didn't pass. Keep studying!
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('student.course.quizzes', $quiz->course_id) }}" class="btn btn-primary">Back to
                        Quizzes</a>
                </div>
            </div>
        </div>
    </div>
@endsection
