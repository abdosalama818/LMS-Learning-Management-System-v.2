<?php

namespace App\Repository;

use App\Interface\SliderInterface;
use App\Models\Slider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SliderRepository implements SliderInterface
{
    // Profile repository methods would go here




    public function storeSlider($data)
    {


        return Slider::create([
            'title' => $data['title'],
            'short_description' => $data['short_description'],
            'video_url' => $data['video_url'],
            'image' => $data['image'],
        ]);
    }

    public function updateSlider($data, $slider)
    {

        $slider->update([
            'title' => $data['title'],
            'short_description' => $data['short_description'],
            'video_url' => $data['video_url'],
            'image' => $data['image'],
        ]);
    }


    public function deleteSlider($id)
    {
        $Slider = Slider::find($id);
        if ($Slider->image && Storage::exists($Slider->image ? $Slider->image : "")) {
            Storage::delete($Slider->image);
        }
        $Slider->delete();
    }


}
