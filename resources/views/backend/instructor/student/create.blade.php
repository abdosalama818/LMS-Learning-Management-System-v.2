@extends('backend.instructor.master')


@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Students</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Student</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->


        <div class="card col-md-12">

            <div class="card-body">

                <div class="card-body p-4">

                    <div style="display: flex; align-items:center; justify-content:space-between">
                        <h5 class="mb-4">Add Student</h5>
                        <a href="{{ route('instructor.student.index') }}" class="btn btn-primary">Back</a>

                    </div>

                    <form class="row g-3" method="post" action="{{ route('instructor.student.store') }}"
                        enctype="multipart/form-data">
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
                            <label for="name" class="form-label">student Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter the student name" value="{{ old('name') }}" required>
                        </div>


                        <div class="col-md-6">
                            <label for="student_email" class="form-label">student Email</label>
                            <input type="email" class="form-control" name="student_email" id="student_email"
                                placeholder="Enter the student email" value="{{ old('student_email') }}" required>
                        </div>



                        <div class="col-md-6">
                            <label for="password" class="form-label">student Password</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Enter the student password" value="{{ old('password') }}" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Choose Courses for Student</label>
                            <div id="courseContainer">
                                <div class="course-item d-flex align-items-center gap-2 mb-2">
                                    <select class="form-select" name="course_id[]" required>
                                        <option value="" disabled selected>Select a course</option>
                                        @foreach ($courses as $item)
                                            <option value="{{ $item->id }}">{{ $item->course_name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-success btn-sm" id="addCourseBtn">+</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label">Student Status</label>
                            <select class="form-select" name="status" id="status" data-placeholder="Choose one thing">

                                <option selected disabled>select</option>

                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>

                            </select>
                        </div>



                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3">
                                <button type="submit" class="btn btn-primary px-4 w-100">Create</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>





    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('video_url').addEventListener('input', function() {
            const videoUrl = this.value; // Get the YouTube URL from the input field
            const videoPreview = document.getElementById('videoPreview'); // Get the iframe element

            if (videoUrl) {
                // Extract YouTube video ID from the URL
                const videoId = extractYouTubeID(videoUrl);
                if (videoId) {
                    // Set the iframe src to embed the YouTube video
                    videoPreview.src = `https://www.youtube.com/embed/${videoId}`;
                    videoPreview.style.display = 'block';
                } else {
                    alert('Invalid YouTube URL');
                    videoPreview.style.display = 'none';
                    videoPreview.src = '';
                }
            } else {
                // Hide the iframe if the input is empty
                videoPreview.style.display = 'none';
                videoPreview.src = '';
            }
        });

        // Function to extract YouTube video ID from URL
        function extractYouTubeID(url) {
            const regex =
                /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
            const match = url.match(regex);
            return match ? match[1] : null;
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".form-check-input").forEach(function(checkbox) {
                checkbox.addEventListener("change", function() {
                    let hiddenInput = this.previousElementSibling; // Hidden input
                    hiddenInput.value = this.checked ? "yes" :
                        "no"; // Set value based on checked state
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            CKEDITOR.replace('description', {
                height: 360
            });
        });
    </script>




<script>
document.addEventListener("DOMContentLoaded", function() {

    const container = document.getElementById('courseContainer');
    const addBtn = document.getElementById('addCourseBtn');

    function getSelectedCourses() {
        const selects = container.querySelectorAll('select[name="course_id[]"]');
        return Array.from(selects).map(sel => sel.value).filter(v => v);
    }

    function createCourseSelect() {
        const selectedCourses = getSelectedCourses();
        const allCourses = @json($courses);

        // فلترة الكورسات اللي تم اختيارها بالفعل
        const availableCourses = allCourses.filter(c => !selectedCourses.includes(c.id.toString()));

        if (availableCourses.length === 0) {
            alert('All courses have been selected.');
            return null;
        }

        const div = document.createElement('div');
        div.classList.add('course-item', 'd-flex', 'align-items-center', 'gap-2', 'mb-2');

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

        // زر الحذف
        div.querySelector('.removeCourseBtn').addEventListener('click', function() {
            div.remove();
        });

        return div;
    }

    addBtn.addEventListener('click', function() {
        const newSelect = createCourseSelect();
        if (newSelect) {
            container.appendChild(newSelect);
        }
    });

});




</script>
    <script src="{{ asset('customjs/instructor/course.js') }}"></script>
@endpush
