@extends('backend.instructor.master')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Quiz Attempts</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('instructor.dashboard') }}"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('instructor.quiz.index') }}">Quizzes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $quiz->title }}</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <a href="{{ route('instructor.quiz.index') }}" class="btn btn-secondary">Back to Quizzes</a>
            </div>
        </div>
        <!--end breadcrumb-->

        <h6 class="mb-0 text-uppercase">Attempts for: {{ $quiz->title }}</h6>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Score</th>
                                <th>Total Questions</th>
                                <th>Attempt Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quiz->attempts as $key => $attempt)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $attempt->student->name }}</td>
                                    <td>{{ $attempt->student->student_email }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $attempt->score >= $attempt->total_questions / 2 ? 'success' : 'danger' }}">
                                            {{ $attempt->score }} / {{ $attempt->total_questions }}
                                        </span>
                                    </td>
                                    <td>{{ $attempt->total_questions }}</td>
                                    <td>{{ $attempt->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
