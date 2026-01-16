@extends('backend.user.master')

@section('content')
<div class="container">

    {{-- Instructor Info --}}
    <div class="top-title mt-5 mb-5 pt-3">
        <div class="row">
            <div class="col-md-10">
                <div class="instructor_info">
                    <h4 class="section-title">Instructor Name: {{ $course->instructor->first_name }} {{ $course->instructor->last_name }}</h4>
                    <p>Phone: {{ $course->instructor->phone }}</p>
                    <p>Bio: {{ $course->instructor->bio }}</p>
                    <p>Experience: {{ $course->instructor->experience }}</p>
                </div>
            </div>
            <div class="col-md-2">
                <img style="object-fit: cover; height: 100px;" class="w-100 rounded-2"
                    src="{{ asset('uploads/' . $course->instructor->photo) }}"
                    alt="{{ $course->instructor->first_name ?? 'Instructor Photo' }}">
            </div>
        </div>
    </div>

    <hr>

    {{-- Course Info --}}
    <div class="course_info mt-5 mb-5 pt-3">
        <div class="row">
            <div class="col-md-6">
                <h4>Course Name: {{ $course->course_name }}</h4>
<div style="display: flex; gap: 5px;">
    <span style="font-weight: 600;">Description:</span>
    <span>{!! $course->description !!}</span>
</div>                <p>Price: {{ $course->selling_price }}</p>
                <p>Lecture Count: {{ $course->courseSections->sum(fn($section) => $section->lectures->count()) }} lecture(s)</p>
                <p>Duration: {{ $course->duration }}</p>
                <ul>
                    <li>Course Goals:</li>
                    @foreach ($course->courseGoals as $goal)
                        <li>{{ $goal->goal_name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    {{-- Course Content --}}
    <div class="course_content mt-5 pt-3">
        <div class="row">

            {{-- Video Player + Lecture Details --}}
            <div class="col-md-8">
                <div class="item video-player">
                    @php
                        $introVideo = $course->video_url ?? null;
                        $firstLecture = optional(optional($course->courseSections->first())->lectures)->first();
                    @endphp

                    @if ($introVideo)
                        <iframe id="mainVideo"
                                src="https://www.youtube.com/embed/{{ youtubeEmbed($introVideo) }}"
                                frameborder="0" allowfullscreen class="w-100" style="height: 420px;"></iframe>
                    @elseif ($firstLecture)
                        <iframe id="mainVideo"
                                src="https://www.youtube.com/embed/{{ youtubeEmbed($firstLecture->url) }}"
                                frameborder="0" allowfullscreen class="w-100" style="height: 420px;"></iframe>
                    @else
                        <p>No video available for this course.</p>
                    @endif

                    {{-- Lecture Details --}}
                    <div class="lecture-details mt-4 p-3 border rounded-2 bg-light">
                        <h3 id="lectureTitle">
                            @if ($introVideo)
                                Intro Video
                            @elseif ($firstLecture)
                                {{ $firstLecture->lecture_title }}
                            @endif
                        </h3>
                        <p><strong>Duration:</strong> <span id="lectureDuration">
                            @if ($introVideo)
                                {{ $course->duration ?? 'N/A' }}
                            @elseif ($firstLecture)
                                {{ $firstLecture->video_duration ?? 'N/A' }}
                            @endif
                        </span></p>
                        <div id="lectureContent">
                            @if ($introVideo)
                                {!! $course->description ?? '' !!}
                            @elseif ($firstLecture)
                                {!! $firstLecture->content ?? '' !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Video List --}}
            <div class="col-md-4">
                <div class="video-list" style="max-height: 500px; overflow-y: auto;">
                    <h4 class="mb-3">Course Lectures</h4>

                    @foreach ($course->courseSections as $section)
                        <h5 class="section-title">{{ $section->section_title }}</h5>

                        @foreach ($section->lectures as $lecture)
                            @php
                                $lectureData = [
                                    'title' => $lecture->lecture_title,
                                    'duration' => $lecture->video_duration,
                                    'content' => $lecture->content
                                ];
                            @endphp
                            <div class="video-item mb-3 p-2 border rounded-2 d-flex cursor-pointer align-items-center"
                                onclick="changeVideo('{{ route('user.course.video', $lecture->id) }}', this, {{ json_encode($lectureData) }})">
                                <img src="https://img.youtube.com/vi/{{ youtubeEmbed($lecture->url) }}/mqdefault.jpg"
                                     alt="{{ $lecture->lecture_title }}" style="width: 100px; height: 60px; object-fit: cover; border-radius: 4px; margin-right: 10px;">
                                <div>
                                    <p class="mb-1"><strong>{{ $lecture->lecture_title }}</strong></p>
                                    <p class="mb-0">Duration: {{ $lecture->video_duration }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endforeach

                </div>
            </div>

        </div>
    </div>
</div>

{{-- JS for changing video and lecture details --}}
<script>
/* function changeVideo(videoId, element, lectureData = {}) {
    const iframe = document.getElementById('mainVideo');
    const titleElem = document.getElementById('lectureTitle');
    const contentElem = document.getElementById('lectureContent');
    const durationElem = document.getElementById('lectureDuration');

    // Change main video
    iframe.src = 'https://www.youtube.com/embed/' + videoId;

    // Update lecture details
    titleElem.innerText ="title of lecture : "  + lectureData.title || 'Video';
    contentElem.innerHTML = lectureData.content || '';
    if(durationElem) durationElem.innerText = lectureData.duration || 'N/A';

    // Highlight active video
    document.querySelectorAll('.video-item').forEach(item => item.classList.remove('active'));
    element.classList.add('active');
} */



function changeVideo(routeUrl, element, lectureData = {}) {
    const iframe = document.getElementById('mainVideo');
    const titleElem = document.getElementById('lectureTitle');
    const contentElem = document.getElementById('lectureContent');
    const durationElem = document.getElementById('lectureDuration');

    // Set iframe src للـ route الديناميكي
    iframe.src = routeUrl;

    // تحديث بيانات المحاضرة
    titleElem.innerText = lectureData.title || 'Video';
    contentElem.innerHTML = lectureData.content || '';
    if(durationElem) durationElem.innerText = lectureData.duration || 'N/A';

    // تمييز المحاضرة النشطة
    document.querySelectorAll('.video-item').forEach(item => item.classList.remove('active'));
    element.classList.add('active');
}


</script>

{{-- Optional CSS --}}
<style>
.video-item:hover { background-color: #f0f8ff; cursor: pointer; }
.video-item.active { background-color: #e0f0ff; border-left: 4px solid #0d6efd; }
.section-title { font-weight: 600; margin-top: 10px; margin-bottom: 5px; }
.lecture-details h3 { margin-bottom: 10px; }
.lecture-details p { margin-bottom: 10px; }
</style>
@endsection
