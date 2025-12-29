<?php

namespace App\Http\Controllers\Dashboard\Admin\Slider;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use App\Services\SliderServices;
use Illuminate\Http\Request;

class SliderController extends Controller
{

    public $SliderServices;
    public function __construct(SliderServices $SliderServices)
    {
        $this->SliderServices = $SliderServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slider = Slider::all();
        return view('backend.admin.slider.index')->with(compact('slider'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderRequest $request)
    {
        try {
            $this->SliderServices->storeSlider($request);
            return redirect()->route('admin.slider.index')->with('success', 'Slider created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the slider: ' . $e->getMessage());
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
        $slider = Slider::find($id);
        return view('backend.admin.slider.edit')->with(compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderRequest $request, string $id)
    {
        try {
            $this->SliderServices->updateSlider($request, $id);
            return redirect()->route('admin.slider.index')->with('success', 'Slider updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the slider: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->SliderServices->deleteSlider($id);
            return redirect()->route('admin.slider.index')->with('success', 'Slider deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the slider: ' . $e->getMessage());
        }
    }
}
