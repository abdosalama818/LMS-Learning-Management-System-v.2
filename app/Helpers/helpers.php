<?php

use App\Models\Category;
use App\Models\Whishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;






if (!function_exists('setSidebar')) {
    function setSidebar(array $routes)
    {
        foreach ($routes as $route) {
            if (request()->is($route)) {
                return 'm-mactive';
            }
        }

        return null;
    }
}

if (!function_exists('getCategories')) {
    function getCategories()
    {
      
      return Cache::remember(Category::CACHE_KEY_SUB,   now()->addMinutes(1) , function () {
          return Category::with('subcategories')->get();

      });
     // return Category::with('subcategories')->get();

    }
}






if(!function_exists('isApprovedUser')){
    function isApprovedUser()
    {
        $instructor = auth()->guard('instructor')->user();
        if ($instructor && $instructor->status === 'active') {
            return true;
        }
    }
   
}


if (!function_exists('makeArabicSlug')) {
function makeArabicSlug($string) {
    // استبدال المسافات بشرطة
    $slug = preg_replace('/\s+/u', '-', trim($string));
    // إزالة الرموز غير المرغوب فيها
    $slug = preg_replace('/[^\p{L}\p{N}\-]+/u', '', $slug);
    return mb_strtolower($slug);
}

}


if(!function_exists('getCourseCategories')){
    function getCourseCategories()
    {
       $categories = Cache::remember(Category::CACHE_KEY_COURSES, 3600, function () {
          return Category::with(['courses' => function ($query) {
              $query->inRandomOrder()->limit(6);
          },'courses.instructor'])->get();
        });
        return $categories;
    }
}

 if (! function_exists('currentGuard')) {
    function currentGuard(): string
    {
        if (Auth::guard('admin')->check()) {
            return 'admin';
        }

        if (Auth::guard('instructor')->check()) {
            return 'instructor';
        }

        return 'web';
    }
}

if(! function_exists('getWishlist')){
    function getWishlist(){
        $user_id = auth('web')->user()->id;
        return Whishlist::where('user_id', $user_id)->get();   
    }
}

if(! function_exists('youtubeEmbed')){

function youtubeEmbed($url)
{
    preg_match(
        '%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
        $url,
        $matches
    );

    return $matches[1] ?? null;
}
}
