<?php

namespace App\Repository;

use \App\Models\CourseSection;



class SectionRepository 
{
  
    public function storeSection($request)
    {
        $section = new CourseSection();
        $section->section_title = $request->section_title;
        $section->course_id = $request->course_id;
        $section->save();
        return $section;
    }


    public function deleteSection($sectionId)
    {
        $section = CourseSection::findOrFail($sectionId);
        return $section->delete();
    }
}