@extends('backend.instructor.master')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Quiz</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('instructor.dashboard') }}"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('instructor.quiz.index') }}">All Quizzes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Quiz</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <div style="display: flex; align-items:center; justify-content:space-between">
                    <h5 class="mb-4">Add Quiz</h5>
                    <a href="{{ route('instructor.quiz.index') }}" class="btn btn-primary">Back</a>
                </div>

                <form class="row g-3" method="post" action="{{ route('instructor.quiz.store') }}">
                    @csrf

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
                        <label for="title" class="form-label">Quiz Title</label>
                        <input type="text" class="form-control" name="title" id="title"
                            placeholder="Enter quiz title" value="{{ old('title') }}" required>
                    </div>

                    <div class="col-md-12">
                        <label for="course_id" class="form-label">Course</label>
                        <select class="form-select" name="course_id" id="course_id" required>
                            <option value="" disabled selected>Select Course</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="duration" class="form-label">Duration (minutes)</label>
                        <input type="number" class="form-control" name="duration" id="duration"
                            placeholder="Enter duration in minutes" value="{{ old('duration') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="start_at" class="form-label">Start Date/Time</label>
                        <input type="datetime-local" class="form-control" name="start_at" id="start_at"
                            value="{{ old('start_at') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="end_at" class="form-label">End Date/Time</label>
                        <input type="datetime-local" class="form-control" name="end_at" id="end_at"
                            value="{{ old('end_at') }}">
                    </div>

                    <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <button type="submit" class="btn btn-primary px-4 w-100">Create Quiz</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
