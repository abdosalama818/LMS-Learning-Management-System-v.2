<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZoomMeeting extends Model
{
    protected $fillable = [
        'instructor_id',
        'course_id',
        'title',
        'meeting_url',
        'start_time',
        'duration',
    ];

    protected $casts = [
        'start_time' => 'datetime',
    ];

    /**
     * Get the instructor that owns the meeting.
     */
    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id', 'id');
    }

    /**
     * Get the course that the meeting belongs to.
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
