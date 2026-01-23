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
                        <li class="breadcrumb-item active" aria-current="page">Questions for: {{ $quiz->title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div style="display: flex; align-items:center; justify-content:space-between">
            <h6 class="mb-0 text-uppercase">Questions List</h6>
            <div>
                <a href="{{ route('instructor.question.create', $quiz->id) }}" class="btn btn-primary">Add Question</a>
                <a href="{{ route('instructor.quiz.index') }}" class="btn btn-secondary">Back to Quizzes</a>
            </div>
        </div>

        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Question</th>
                                <th>Option A</th>
                                <th>Option B</th>
                                <th>Option C</th>
                                <th>Option D</th>
                                <th>Answer</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($questions as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ Str::limit($item->question, 50) }}</td>
                                    <td>{{ $item->option_a }}</td>
                                    <td>{{ $item->option_b }}</td>
                                    <td>{{ $item->option_c }}</td>
                                    <td>{{ $item->option_d }}</td>
                                    <td><span class="badge bg-success">{{ $item->answer }}</span></td>
                                    <td>
                                        <a href="{{ route('instructor.question.edit', $item->id) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="bx bx-edit"></i>
                                        </a>

                                        <form method="POST" action="{{ route('instructor.question.destroy', $item->id) }}"
                                            style="display:inline-block;"
                                            onsubmit="return confirm('Are you sure you want to delete this question?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
