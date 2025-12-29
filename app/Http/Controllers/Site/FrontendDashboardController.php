<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\InfoBox;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class FrontendDashboardController extends Controller
{
  public function index()
  {
    $all_sliders = Cache::remember('sliders', 3600, function () {
      return Slider::all();
    });


    $all_info = Cache::remember('all_info', 3600, function () {
      return InfoBox::all();
    });

    $all_categories = Cache::remember('all_categories', 3600, function () {
      return Category::with('subcategories')->inRandomOrder()->limit(6)->get();
    });
 


    return view('frontend.index')->with(compact('all_sliders', 'all_info', 'all_categories'));
  }
}
