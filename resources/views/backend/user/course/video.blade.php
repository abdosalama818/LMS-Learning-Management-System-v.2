<iframe width="100%" height="500"
        src="https://www.youtube.com/embed/{{ $videoId }}?rel=0&modestbranding=1"
        frameborder="0"
        allowfullscreen>
</iframe>
<div class="lecture-details mt-3">
    <h3>{{ $lecture->lecture_title }}</h3>
    <p><strong>Duration:</strong> {{ $lecture->video_duration }}</p>
    <div>{!! $lecture->content !!}</div>
</div>
