@extends('backend.instructor.master')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Zoom Meetings</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('instructor.dashboard') }}"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('instructor.zoom-meeting.index') }}">All Zoom
                                Meetings</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Zoom Meeting</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <div style="display: flex; align-items:center; justify-content:space-between">
                    <h5 class="mb-4">Add Zoom Meeting</h5>
                    <a href="{{ route('instructor.zoom-meeting.index') }}" class="btn btn-primary">Back</a>
                </div>

                <form class="row g-3" method="post" action="{{ route('instructor.zoom-meeting.store') }}">
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
                        <label for="title" class="form-label">Meeting Title</label>
                        <input type="text" class="form-control" name="title" id="title"
                            placeholder="Enter meeting title" value="{{ old('title') }}" required>
                    </div>

                    <div class="col-md-12">
                        <label for="course_id" class="form-label">Course</label>
                        <select class="form-select" name="course_id" id="course_id" required>
                            <option value="" disabled selected>Select Course</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->course_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="meeting_url" class="form-label">Meeting URL</label>
                        <input type="url" class="form-control" name="meeting_url" id="meeting_url"
                            placeholder="https://zoom.us/j/..." value="{{ old('meeting_url') }}" required>
                        <small class="text-muted">Enter the full Zoom meeting link</small>
                    </div>

                    <div class="col-md-6">
                        <label for="start_time" class="form-label">Start Date/Time</label>
                        <input type="datetime-local" class="form-control" name="start_time" id="start_time"
                            value="{{ old('start_time') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="duration" class="form-label">Duration (minutes)</label>
                        <input type="number" class="form-control" name="duration" id="duration"
                            placeholder="Enter duration in minutes" value="{{ old('duration', 60) }}" min="1"
                            required>
                    </div>

                    <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <button type="submit" class="btn btn-primary px-4 w-100">Create Zoom Meeting</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
