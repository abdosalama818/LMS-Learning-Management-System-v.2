<?php

namespace App\Http\Controllers\Dashboard\Instructor\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\LectureRequest;
use App\Models\CourseLecture;
use App\Services\LectureService;
use Illuminate\Http\Request;

class CourseLectureController extends Controller
{

    public $lectureService;

    public function __construct(LectureService $LectureService)
    {
        $this->lectureService = $LectureService;
    }
  
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LectureRequest $request)
    {
        try{
            $lectureService = app()->make('App\Services\LectureService');
            $lecture = $lectureService->storeLecture($request);
            return redirect()->back()->with('success', 'Lecture created successfully.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'An error occurred while creating the lecture: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LectureRequest $request, CourseLecture $lecture)
    {
        try{
            $this->lectureService->updateLecture($lecture, $request);
            return redirect()->back()->with('success', 'Lecture updated successfully.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'An error occurred while updating the lecture: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
       try{
            $this->lectureService->deleteLecture($id);
            return redirect()->back()->with('success', 'Lecture deleted successfully.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'An error occurred while deleting the lecture: ' . $e->getMessage());
        }
    }
       
}
