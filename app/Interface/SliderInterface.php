<?php

namespace App\Interface;

use App\Models\Category;

interface SliderInterface
{
    public function storeSlider($request);
    public function updateSlider($request, $id);
    public function deleteSlider($id);


}
