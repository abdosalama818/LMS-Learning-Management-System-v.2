<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\InfoBox;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class FrontendDashboardController extends Controller
{
  public function index()
  {



    $all_sliders = Cache::remember(Slider::CACHE_KEY, 3600, function () {
      return Slider::all();
    });


    $all_info = InfoBox::all();
  

    $all_categories = Cache::remember(Category::CACHE_KEY_SUB, 3600, function () {
      return Category::with('subcategories')->inRandomOrder()->limit(6)->get();
    });

    $categories = Cache::remember(Category::CACHE_KEY_ALL_CATEGORIES, 3600, function () {
      return Category::all();
    });

    $course_category = Cache::remember(Category::CACHE_KEY_COURSES, 3600, function () {
      return Category::with(['courses' => function ($query) {
          $query->inRandomOrder()->limit(6);
      },'courses.instructor'])->get();
    });
    



    return view('frontend.index')->with(compact('all_sliders', 'all_info', 'all_categories', 'course_category', 'categories'));
  }


  public function courseDetails($slug)
  {

    $course = Course::where('course_name_slug', $slug)->with('instructor', 'category', 'subCategory','courseGoals')->firstOrFail();
     $course_content = CourseSection::where('course_id', $course->id)->with('lectures')->get();
      $total_lecture = $course_content->sum(function ($course_content) {
        return $course_content->lectures->count();
      });
     
      $total_lecture_duration =  $course_content->sum(function ($course_content) {
        return $course_content->lectures->sum('video_duration');
      });
      $similarCourses  = Course::where('category_id', $course->category_id)
      ->where('id', '!=', $course->id)
      ->inRandomOrder()
      ->limit(4)
      ->get();
      $more_course_instructor = Course::where('instructor_id', $course->instructor_id)
      ->where('id', '!=', $course->id)->with('instructor')
      ->inRandomOrder()
      ->limit(4)
      ->get();

        $all_category = Category::orderBy('name', 'asc')->get();

    return view('frontend.pages.course-details.index')->with(compact(
      'course', 
    'total_lecture',
     'course_content', 
     'similarCourses', 
     'total_lecture_duration',
     'more_course_instructor',
      'all_category'
    ));
  }
}
