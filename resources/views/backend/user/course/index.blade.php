@extends('backend.user.master')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">My Courses</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Courses</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <hr />

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            @foreach ($all_courses as $item)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 course-card">
                        <div class="position-relative overflow-hidden">
                            <a href="{{ route('user.course.show', $item->id) }}">
                                @if ($item->course_image)
                                    <img src="{{ asset('uploads/' . $item->course_image) }}" class="card-img-top course-img"
                                        alt="{{ $item->course_name }}">
                                @else
                                    <img src="https://via.placeholder.com/300x200?text=No+Image"
                                        class="card-img-top course-img" alt="No Image">
                                @endif
                            </a>
                            @if ($item->category)
                                <span
                                    class="badge bg-primary position-absolute top-0 start-0 m-2 rounded-3">{{ $item->category->name }}</span>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            @if ($item->subCategory)
                                <div class="mb-2">
                                    <span class="badge bg-light text-dark border">{{ $item->subCategory->name }}</span>
                                </div>
                            @endif

                            <h5 class="card-title text-truncate-2 mb-3">
                                <a href="{{ route('user.course.show', $item->id) }}"
                                    class="text-dark text-decoration-none">{{ $item->course_name }}</a>
                            </h5>

                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        @if ($item->discount_price > 0)
                                            <span class="fs-5 fw-bold text-success">${{ $item->discount_price }}</span>
                                            <span
                                                class="text-muted text-decoration-line-through ms-1 small">${{ $item->selling_price }}</span>
                                        @else
                                            <span class="fs-5 fw-bold text-dark">${{ $item->selling_price }}</span>
                                        @endif
                                    </div>
                                    <!-- Optional: Rating or other meta info could go here -->
                                </div>
                                <div class="d-grid">
                                    <a href="{{ route('user.course.show', $item->id) }}" class="btn btn-primary">
                                        <i class="bx bx-play-circle me-1"></i> Continue Learning
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($all_courses->isEmpty())
            <div class="alert alert-info text-center">
                You are not enrolled in any courses yet.
            </div>
        @endif
    </div>

    <style>
        .course-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }

        .course-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 3em;
            /* Approximate height for 2 lines */
        }
    </style>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.delete-category', function(e) {
            e.preventDefault();

            let categoryId = $(this).data('id');
            let deleteUrl = "{{ route('instructor.course.destroy', ':id') }}".replace(':id', categoryId);

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-form').attr('action', deleteUrl).submit();
                }
            });
        });
    </script>
@endpush
