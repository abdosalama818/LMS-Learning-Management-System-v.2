<?php

namespace App\Repository;

use App\Models\CourseLecture;




class LectureRepository 
{

    public function storeLecture($data)
    {
     
        return CourseLecture::create([
            'course_id' => $data['course_id'],
            'section_id' => $data['section_id'],
            'lecture_title' => $data['lecture_title'],
            'url' => $data['url'],
            'video_duration' => $data['video_duration'],
            'content' => $data['content'] ?? null,
        ]);
    }


    public function updateLecture(CourseLecture $lecture, $data)
    {
        $lecture->update([
            'lecture_title' => $data['lecture_title'],
            'url' => $data['url'],
            'video_duration' => $data['video_duration'],
            'content' => $data['content'] ?? null,
        ]);
        return $lecture;
    }

    public function deleteLecture($lecture)
    {
        return $lecture->delete(); 
    }
}