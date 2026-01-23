<?php

namespace App\Http\Controllers\Dashboard\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\ZoomMeeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ZoomMeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meetings = ZoomMeeting::where('instructor_id', Auth::guard('instructor')->id())
            ->with('course')
            ->latest()
            ->get();

        return view('backend.instructor.zoom-meeting.index', compact('meetings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::where('instructor_id', Auth::guard('instructor')->id())->get();
        return view('backend.instructor.zoom-meeting.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'meeting_url' => 'required|url|max:500',
            'start_time' => 'required|date',
            'duration' => 'required|integer|min:1',
        ]);

        ZoomMeeting::create([
            'title' => $request->title,
            'instructor_id' => Auth::guard('instructor')->id(),
            'course_id' => $request->course_id,
            'meeting_url' => $request->meeting_url,
            'start_time' => $request->start_time,
            'duration' => $request->duration,
        ]);

        return redirect()->route('instructor.zoom-meeting.index')->with('success', 'Zoom meeting created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $meeting = ZoomMeeting::where('instructor_id', Auth::guard('instructor')->id())->findOrFail($id);
        $courses = Course::where('instructor_id', Auth::guard('instructor')->id())->get();

        return view('backend.instructor.zoom-meeting.edit', compact('meeting', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $meeting = ZoomMeeting::where('instructor_id', Auth::guard('instructor')->id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'meeting_url' => 'required|url|max:500',
            'start_time' => 'required|date',
            'duration' => 'required|integer|min:1',
        ]);

        $meeting->update([
            'title' => $request->title,
            'course_id' => $request->course_id,
            'meeting_url' => $request->meeting_url,
            'start_time' => $request->start_time,
            'duration' => $request->duration,
        ]);

        return redirect()->route('instructor.zoom-meeting.index')->with('success', 'Zoom meeting updated successfully');
    }
}
