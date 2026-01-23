@extends('backend.user.master')

@section('content')
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Take Quiz</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $quiz->title }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">{{ $quiz->title }}</h5>
                <p class="mb-4">{{ $quiz->description }}</p>
                <div class="alert alert-info">
                    <strong>Time limit:</strong> {{ $quiz->duration }} minutes
                </div>

                <form action="{{ route('student.quiz.submit', $quiz->id) }}" method="POST">
                    @csrf
                    @foreach ($quiz->questions as $index => $question)
                        <div class="card mb-3">
                            <div class="card-header">
                                <strong>Question {{ $index + 1 }}:</strong> {{ $question->question }}
                            </div>
                            <div class="card-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="q_{{ $question->id }}"
                                        id="q{{ $question->id }}_a" value="option_a">
                                    <label class="form-check-label"
                                        for="q{{ $question->id }}_a">{{ $question->option_a }}</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="q_{{ $question->id }}"
                                        id="q{{ $question->id }}_b" value="option_b">
                                    <label class="form-check-label"
                                        for="q{{ $question->id }}_b">{{ $question->option_b }}</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="q_{{ $question->id }}"
                                        id="q{{ $question->id }}_c" value="option_c">
                                    <label class="form-check-label"
                                        for="q{{ $question->id }}_c">{{ $question->option_c }}</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="q_{{ $question->id }}"
                                        id="q{{ $question->id }}_d" value="option_d">
                                    <label class="form-check-label"
                                        for="q{{ $question->id }}_d">{{ $question->option_d }}</label>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success btn-lg px-5">Submit Quiz</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
