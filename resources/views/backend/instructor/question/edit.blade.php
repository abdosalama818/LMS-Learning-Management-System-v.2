@extends('backend.instructor.master')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Questions</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('instructor.dashboard') }}"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('instructor.quiz.index') }}">All Quizzes</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('instructor.question.index', $question->quiz_id) }}">Questions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Question</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <div style="display: flex; align-items:center; justify-content:space-between">
                    <h5 class="mb-4">Edit Question</h5>
                    <a href="{{ route('instructor.question.index', $question->quiz_id) }}" class="btn btn-primary">Back</a>
                </div>

                <form class="row g-3" method="post" action="{{ route('instructor.question.update', $question->id) }}">
                    @csrf
                    {{-- @method('PUT') --}}
                    <!-- Assuming web.php uses post for update based on previous context, usually resources use PUT/PATCH but manual routes were added as POST. Checking earlier steps... manual route is POST -->

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="col-md-12">
                        <label for="question" class="form-label">Question</label>
                        <textarea class="form-control" name="question" id="question" rows="3" required>{{ old('question', $question->question) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="option_a" class="form-label">Option A</label>
                        <input type="text" class="form-control" name="option_a" id="option_a"
                            value="{{ old('option_a', $question->option_a) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="option_b" class="form-label">Option B</label>
                        <input type="text" class="form-control" name="option_b" id="option_b"
                            value="{{ old('option_b', $question->option_b) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="option_c" class="form-label">Option C</label>
                        <input type="text" class="form-control" name="option_c" id="option_c"
                            value="{{ old('option_c', $question->option_c) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="option_d" class="form-label">Option D</label>
                        <input type="text" class="form-control" name="option_d" id="option_d"
                            value="{{ old('option_d', $question->option_d) }}" required>
                    </div>

                    <div class="col-md-12">
                        <label for="answer" class="form-label">Correct Answer</label>
                        <select class="form-select" name="answer" id="answer" required>
                            <option value="" disabled>Select Correct Answer</option>
                            <option value="option_a"
                                {{ old('answer', $question->answer) == 'option_a' ? 'selected' : '' }}>Option A</option>
                            <option value="option_b"
                                {{ old('answer', $question->answer) == 'option_b' ? 'selected' : '' }}>Option B</option>
                            <option value="option_c"
                                {{ old('answer', $question->answer) == 'option_c' ? 'selected' : '' }}>Option C</option>
                            <option value="option_d"
                                {{ old('answer', $question->answer) == 'option_d' ? 'selected' : '' }}>Option D</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <button type="submit" class="btn btn-primary px-4 w-100">Update Question</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
