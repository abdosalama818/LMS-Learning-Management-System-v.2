@extends('backend.user.master')

@section('content')
    <div class="page-content">

        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-4">
            <div class="pr-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('user.course.index') }}">My Courses</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($course->course_name, 30) }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Course Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="font-weight-bold mb-2">{{ $course->course_name }}</h2>
                <div class="d-flex align-items-center text-muted">
                    <span class="mr-3"><i class="bx bx-time mr-1"></i> {{ $course->duration }}</span>
                    <span><i class="bx bx-layer mr-1"></i>
                        {{ $course->courseSections->sum(fn($section) => $section->lectures->count()) }} lectures</span>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content (Video Player) -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-0">
                        @php
                            $introVideo = $course->video_url ?? null;
                            $firstLecture = optional(optional($course->courseSections->first())->lectures)->first();
                        @endphp

                        <!-- BS4 Responsive Embed -->
                        <div class="embed-responsive embed-responsive-16by9 bg-dark">
                            @if ($introVideo)
                                <iframe class="embed-responsive-item" id="mainVideo"
                                    src="https://www.youtube.com/embed/{{ youtubeEmbed($introVideo) }}"
                                    allowfullscreen></iframe>
                            @elseif ($firstLecture)
                                <iframe class="embed-responsive-item" id="mainVideo"
                                    src="https://www.youtube.com/embed/{{ youtubeEmbed($firstLecture->url) }}"
                                    allowfullscreen></iframe>
                            @else
                                <div
                                    class="d-flex align-items-center justify-content-center text-white h-100 embed-responsive-item">
                                    <p>No video available for this course.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Lecture Details & Tabs -->
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <!-- BS4 Tabs -->
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-overview-tab" data-toggle="pill" href="#pills-overview"
                                    role="tab" aria-controls="pills-overview" aria-selected="true">Overview</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-instructor-tab" data-toggle="pill" href="#pills-instructor"
                                    role="tab" aria-controls="pills-instructor" aria-selected="false">Instructor</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">

                            <!-- Overview Tab -->
                            <div class="tab-pane fade show active" id="pills-overview" role="tabpanel"
                                aria-labelledby="pills-overview-tab">
                                <h4 id="lectureTitle" class="mb-3">
                                    @if ($introVideo)
                                        Intro Video
                                    @elseif ($firstLecture)
                                        {{ $firstLecture->lecture_title }}
                                    @endif
                                </h4>
                                <p class="text-muted mb-4">
                                    <strong>Duration:</strong>
                                    <span id="lectureDuration">
                                        @if ($introVideo)
                                            {{ $course->duration ?? 'N/A' }}
                                        @elseif ($firstLecture)
                                            {{ $firstLecture->video_duration ?? 'N/A' }}
                                        @endif
                                    </span>
                                </p>
                                <div id="lectureContent" class="course-description">
                                    @if ($introVideo)
                                        {!! $course->description ?? '' !!}
                                    @elseif ($firstLecture)
                                        {!! $firstLecture->content ?? '' !!}
                                    @endif
                                </div>

                                <hr class="my-4">

                                <h5 class="mb-3">Course Goals</h5>
                                <ul class="list-group list-group-flush">
                                    @foreach ($course->courseGoals as $goal)
                                        <li class="list-group-item bg-transparent px-0"><i
                                                class="bx bx-check text-success mr-2"></i>{{ $goal->goal_name }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Instructor Tab -->
                            <div class="tab-pane fade" id="pills-instructor" role="tabpanel"
                                aria-labelledby="pills-instructor-tab">
                                <div class="media">
                                    <img src="{{ asset('uploads/' . $course->instructor->photo) }}"
                                        class="rounded-circle mr-3" width="80" height="80"
                                        alt="{{ $course->instructor->first_name }}">
                                    <div class="media-body">
                                        <h5 class="mt-0 mb-1">{{ $course->instructor->first_name }}
                                            {{ $course->instructor->last_name }}</h5>
                                        <p class="text-muted mb-2">{{ $course->instructor->phone }}</p>
                                        <div class="small mb-2">{{ $course->instructor->bio }}</div>
                                        <span class="badge badge-light border">{{ $course->instructor->experience }}
                                            Experience</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar (Playlist) -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 80px; max-height: calc(100vh - 100px);">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0">Course Content</h5>
                    </div>
                    <!-- Action Buttons -->
                    <div class="px-3 py-2 border-bottom">
                        <a href="{{ route('student.course.quizzes', $course->id) }}"
                            class="btn btn-warning btn-block btn-sm">
                            <i class='bx bx-question-mark mr-1'></i> Take Quiz
                        </a>
                    </div>

                    <div class="accordion flex-grow-1 overflow-auto" id="courseAccordion" style="max-height: 600px;">
                        @foreach ($course->courseSections as $index => $section)
                            <div class="card border-0 mb-0">
                                <div class="card-header bg-light p-0" id="heading{{ $section->id }}">
                                    <h2 class="mb-0">
                                        <button
                                            class="btn btn-link btn-block text-left d-flex align-items-center justify-content-between p-3"
                                            type="button" data-toggle="collapse"
                                            data-target="#collapse{{ $section->id }}"
                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                            aria-controls="collapse{{ $section->id }}"
                                            style="text-decoration: none; color: inherit;">
                                            <div>
                                                <span
                                                    class="font-weight-bold d-block">{{ $section->section_title }}</span>
                                                <small class="text-muted">{{ $section->lectures->count() }}
                                                    lectures</small>
                                            </div>
                                            <i class="bx bx-chevron-down"></i>
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapse{{ $section->id }}" class="collapse {{ $index === 0 ? 'show' : '' }}"
                                    aria-labelledby="heading{{ $section->id }}" data-parent="#courseAccordion">
                                    <div class="card-body p-0">
                                        <div class="list-group list-group-flush">
                                            @foreach ($section->lectures as $lecture)
                                                @php
                                                    $lectureData = [
                                                        'title' => $lecture->lecture_title,
                                                        'duration' => $lecture->video_duration,
                                                        'content' => $lecture->content,
                                                    ];
                                                @endphp
                                                <a href="javascript:;"
                                                    class="list-group-item list-group-item-action video-item d-flex align-items-start py-3"
                                                    onclick="changeVideo('https://www.youtube.com/embed/{{ youtubeEmbed($lecture->url) }}?autoplay=1', this, {{ json_encode($lectureData) }})">

                                                    <div class="position-relative flex-shrink-0 mr-3">
                                                        <img src="https://img.youtube.com/vi/{{ youtubeEmbed($lecture->url) }}/default.jpg"
                                                            alt="{{ $lecture->lecture_title }}" class="rounded"
                                                            style="width: 100px; height: 56px; object-fit: cover;"
                                                            onerror="this.src='https://via.placeholder.com/100x56?text=Video'">
                                                        <div class="overlay-icon">
                                                            <i class='bx bx-play-circle fs-3 text-white'></i>
                                                        </div>
                                                    </div>

                                                    <div class="media-body min-w-0">
                                                        <h6 class="mb-1 text-truncate font-weight-bold lecture-title">
                                                            {{ $lecture->lecture_title }}</h6>
                                                        <small class="text-muted d-block"><i class='bx bx-time-five'></i>
                                                            {{ $lecture->video_duration }}</small>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- JS -->
    <script>
        function changeVideo(routeUrl, element, lectureData = {}) {
            const iframe = document.getElementById('mainVideo');
            const titleElem = document.getElementById('lectureTitle');
            const contentElem = document.getElementById('lectureContent');
            const durationElem = document.getElementById('lectureDuration');

            // Update iframe
            iframe.src = routeUrl;

            // Update details
            if (titleElem) titleElem.innerText = lectureData.title || 'Video';
            if (contentElem) contentElem.innerHTML = lectureData.content || '';
            if (durationElem) durationElem.innerText = lectureData.duration || 'N/A';

            // Reset all items
            document.querySelectorAll('.video-item').forEach(item => {
                item.classList.remove('active', 'bg-primary-light');
                const title = item.querySelector('.lecture-title');
                if (title) title.classList.remove('text-primary');

                // Show play icon overlay
                const overlay = item.querySelector('.overlay-icon');
                if (overlay) overlay.style.display = 'flex';
            });

            // Activate current item
            element.classList.add('active', 'bg-primary-light');
            const activeTitle = element.querySelector('.lecture-title');
            if (activeTitle) activeTitle.classList.add('text-primary');

            // Hide play icon overlay
            const activeOverlay = element.querySelector('.overlay-icon');
            if (activeOverlay) activeOverlay.style.display = 'none';
        }
    </script>

    <style>
        .embed-responsive-16by9::before {
            padding-top: 56.25%;
        }

        .bg-primary-light {
            background-color: #e3f2fd;
            border-left: 4px solid #007bff;
        }

        .video-item {
            border-left: 4px solid transparent;
        }

        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .overlay-icon {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.25rem;
        }

        /* Sticky fallback for older browsers or if sticky-top missing */
        .sticky-top {
            position: -webkit-sticky;
            position: sticky;
            top: 80px;
            z-index: 1020;
        }
    </style>
@endsection
