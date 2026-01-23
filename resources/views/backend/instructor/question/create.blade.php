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
                                href="{{ route('instructor.question.index', $quiz->id) }}">Questions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Questions</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <div style="display: flex; align-items:center; justify-content:space-between">
                    <h5 class="mb-4">Add Questions to: {{ $quiz->title }}</h5>
                    <a href="{{ route('instructor.question.index', $quiz->id) }}" class="btn btn-primary">Back</a>
                </div>

                <form class="row g-3" method="post" action="{{ route('instructor.question.store') }}">
                    @csrf
                    <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">

                    <div id="questions_container">
                        <!-- Single Question Item -->
                        <div class="question-item card p-3 mb-3">
                            <h6 class="card-title">Question 1</h6>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Question</label>
                                    <textarea class="form-control" name="questions[0][question]" rows="2" required></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Option A</label>
                                    <input type="text" class="form-control" name="questions[0][option_a]" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Option B</label>
                                    <input type="text" class="form-control" name="questions[0][option_b]" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Option C</label>
                                    <input type="text" class="form-control" name="questions[0][option_c]" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Option D</label>
                                    <input type="text" class="form-control" name="questions[0][option_d]" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Correct Answer</label>
                                    <select class="form-select" name="questions[0][answer]" required>
                                        <option value="" disabled selected>Select Correct Answer</option>
                                        <option value="option_a">Option A</option>
                                        <option value="option_b">Option B</option>
                                        <option value="option_c">Option C</option>
                                        <option value="option_d">Option D</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-success" id="add_question_btn">Add Another Question</button>
                    </div>

                    <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <button type="submit" class="btn btn-primary px-4 w-100">Save All Questions</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let questionIndex = 1;
                const container = document.getElementById('questions_container');
                const addBtn = document.getElementById('add_question_btn');

                addBtn.addEventListener('click', function() {
                    const questionHtml = `
                    <div class="question-item card p-3 mb-3">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h6 class="card-title">Question ${questionIndex + 1}</h6>
                            <button type="button" class="btn btn-danger btn-sm remove-question">Remove</button>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Question</label>
                                <textarea class="form-control" name="questions[${questionIndex}][question]" rows="2" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Option A</label>
                                <input type="text" class="form-control" name="questions[${questionIndex}][option_a]" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Option B</label>
                                <input type="text" class="form-control" name="questions[${questionIndex}][option_b]" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Option C</label>
                                <input type="text" class="form-control" name="questions[${questionIndex}][option_c]" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Option D</label>
                                <input type="text" class="form-control" name="questions[${questionIndex}][option_d]" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Correct Answer</label>
                                <select class="form-select" name="questions[${questionIndex}][answer]" required>
                                    <option value="" disabled selected>Select Correct Answer</option>
                                    <option value="option_a">Option A</option>
                                    <option value="option_b">Option B</option>
                                    <option value="option_c">Option C</option>
                                    <option value="option_d">Option D</option>
                                </select>
                            </div>
                        </div>
                    </div>
                `;
                    container.insertAdjacentHTML('beforeend', questionHtml);
                    questionIndex++;
                });

                container.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-question')) {
                        e.target.closest('.question-item').remove();
                    }
                });
            });
        </script>
    @endpush
@endsection
