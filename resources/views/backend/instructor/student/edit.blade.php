@extends('backend.instructor.master')

@section('content')
<div class="page-content">

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Students</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active">Edit Student</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card col-md-12">
        <div class="card-body p-4">

            <div style="display: flex; align-items:center; justify-content:space-between">
                <h5 class="mb-4">Edit Student</h5>
                <a href="{{ route('instructor.student.index') }}" class="btn btn-primary">Back</a>
            </div>

            <form class="row g-3"
                  method="post"
                  action="{{ route('instructor.student.update', $student->id) }}">
                @csrf
                @method('PUT')

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Name --}}
                <div class="col-md-12">
                    <label class="form-label">Student Name</label>
                    <input type="text"
                           class="form-control"
                           name="name"
                           value="{{ old('name', $student->name) }}"
                           required>
                </div>

                {{-- Email --}}
                <div class="col-md-6">
                    <label class="form-label">Student Email</label>
                    <input type="email"
                           class="form-control"
                           name="student_email"
                           value="{{ old('student_email', $student->student_email) }}"
                           required>
                </div>

                {{-- Password --}}
                <div class="col-md-6">
                    <label class="form-label">Student Password</label>
                    <input type="password"
                           class="form-control"
                           name="password"
                           placeholder="Leave empty to keep current password">
                </div>

                {{-- Courses --}}
                <div class="col-md-12">
                    <label class="form-label">Choose Courses for Student</label>

                    <div id="courseContainer">

                        @foreach ($studentCourseIds as $courseId)
                            <div class="course-item d-flex align-items-center gap-2 mb-2">
                                <select class="form-select" name="course_id[]" required>
                                    <option disabled>Select a course</option>
                                    @foreach ($courses as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $courseId ? 'selected' : '' }}>
                                            {{ $item->course_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-danger btn-sm removeCourseBtn">-</button>
                            </div>
                        @endforeach

                        <button type="button" class="btn btn-success btn-sm" id="addCourseBtn">+</button>
                    </div>
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                    <label class="form-label">Student Status</label>
                    <select class="form-select" name="status" required>
                        <option disabled>select</option>
                        <option value="active" {{ $student->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $student->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                {{-- Submit --}}
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary px-4 w-100">
                        Update
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {

    const container = document.getElementById('courseContainer');
    const addBtn = document.getElementById('addCourseBtn');

    // 🟢 حذف أي كورس (قديم أو جديد)
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeCourseBtn')) {
            e.target.closest('.course-item').remove();
        }
    });

    function getSelectedCourses() {
        const selects = container.querySelectorAll('select[name="course_id[]"]');
        return Array.from(selects).map(sel => sel.value).filter(v => v);
    }

    function createCourseSelect() {
        const selectedCourses = getSelectedCourses();
        const allCourses = @json($courses);

        const availableCourses = allCourses.filter(
            c => !selectedCourses.includes(c.id.toString())
        );

        if (availableCourses.length === 0) {
            alert('All courses have been selected.');
            return null;
        }

        const div = document.createElement('div');
        div.classList.add('course-item','d-flex','align-items-center','gap-2','mb-2');

        let options = '<option value="" disabled selected>Select a course</option>';
        availableCourses.forEach(c => {
            options += `<option value="${c.id}">${c.course_name}</option>`;
        });

        div.innerHTML = `
            <select class="form-select" name="course_id[]" required>
                ${options}
            </select>
            <button type="button" class="btn btn-danger btn-sm removeCourseBtn">-</button>
        `;

        return div;
    }

    addBtn.addEventListener('click', () => {
        const select = createCourseSelect();
        if (select) container.appendChild(select);
    });

});
</script>

<script src="{{ asset('customjs/instructor/course.js') }}"></script>
@endpush
