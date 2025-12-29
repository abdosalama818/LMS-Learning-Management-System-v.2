<?php

namespace App\Services;

use App\Interface\SliderInterface;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
;

class SliderServices
{
   public $SliderRepository;
    public function __construct(SliderInterface $SliderRepository)
    {
         $this->SliderRepository = $SliderRepository;
    }

    public function storeSlider( $request){
        $data = $request->validated();
         $path = Storage::putFile('slider', $request->file('image'));
         $data['image'] = $path;
        return $this->SliderRepository->storeSlider($data);
    }
public function updateSlider($request, $id)
{
    $data = $request->validated();

    $slider = Slider::findOrFail($id);

    $oldImage = $slider->image;

    if ($request->hasFile('image')) {

        if ($oldImage && Storage::exists($oldImage)) {
            Storage::delete($oldImage);
        }

        $data['image'] = Storage::putFile('slider', $request->file('image'));
    } else {
        $data['image'] = $oldImage;
    }

    return $this->SliderRepository->updateSlider($data, $slider);
}

    public function deleteSlider($id){
        return $this->SliderRepository->deleteSlider($id);
    }




}
