<?php

namespace App\Services;

use App\Http\Requests\LectureRequest;
use App\Models\CourseLecture;
use App\Repository\LectureRepository;



class LectureService
{
    public $lectureRepository;

    public function __construct(LectureRepository $lectureRepository)
    {
        $this->lectureRepository = $lectureRepository;
    }

    public function storeLecture(LectureRequest $request)
    {
        $data = $request->validated();
        return $this->lectureRepository->storeLecture($data);
    }

    public function updateLecture(CourseLecture $lecture, LectureRequest $request)
    {
         $data = $request->validated();
        return $this->lectureRepository->updateLecture($lecture, $data);
    }

    public function deleteLecture($lectureId)
    {
        $lecture = CourseLecture::findOrFail($lectureId);
        return $this->lectureRepository->deleteLecture($lecture);

    }
}
   