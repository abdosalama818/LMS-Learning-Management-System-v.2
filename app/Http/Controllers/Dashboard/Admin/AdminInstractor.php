<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Http\Request;

class AdminInstractor extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all_instructors = Instructor::all();
        return view('backend.admin.instructor.index')->with(compact('all_instructors'));
    }


    public function updateStatus(Request $request)
    {
        $instructor = Instructor::find($request->user_id);
        if ($instructor) {
            $instructor->status = $request->status;
            $instructor->save();
            return response()->json(['success' => true, 'message' => 'Instructor status updated successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Instructor not found.'], 404);
        }
    }


    public function activeList()
    {
        $active_instructor  = Instructor::where('status', 'active')->get();
        return view('backend.admin.instructor.active')->with(compact('active_instructor'));
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
