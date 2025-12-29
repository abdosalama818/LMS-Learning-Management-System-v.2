<?php

namespace App\Http\Controllers\Dashboard\Admin\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\InfoRequest;
use App\Models\InfoBox;
use App\Services\InfoServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class InfoController extends Controller
{
    public $infoServices;

    public function __construct(InfoServices $infoServices)
    {
        $this->infoServices = $infoServices;
    }
    public function index()
    {
        $first_info = Cache::remember(
            InfoBox::CACHE_KEY1,
            1800,
            fn() => InfoBox::find(1)
        );

        $second_info = Cache::remember(
            InfoBox::CACHE_KEY2,
            1800,
            fn() => InfoBox::find(2)
        );
        $third_info = Cache::remember(
            InfoBox::CACHE_KEY3,
            1800,
            fn() => InfoBox::find(3)
        );


        return view('backend.admin.info.index', compact('first_info', 'second_info', 'third_info'));
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
    public function update(InfoRequest $request,  $id)
    {


        $validated = $request->validated();

        try {
            $this->infoServices->updateInfo($request, $id);
            $notification = array(
                'message' => 'slider updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'some thing is worng ' . $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->infoServices->deleteInfo($id);
    }
}
