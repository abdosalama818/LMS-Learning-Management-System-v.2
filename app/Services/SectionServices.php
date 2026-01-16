<?php

namespace App\Services;

use App\Http\Requests\CourseRequest;
use App\Repository\SectionRepository;

class SectionServices
{
    public $sectionRepository;

    public function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    public function storeSection($request)
    {
        $request->validate([
            'section_title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
        ]);

        return $this->sectionRepository->storeSection($request);
    }

    public function deleteSection($sectionId)
    {
        return $this->sectionRepository->deleteSection($sectionId);

    }
}
   