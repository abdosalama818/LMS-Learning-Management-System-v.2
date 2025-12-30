<?php

use App\Models\Category;
use Illuminate\Support\Facades\Cache;


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
      
      return Cache::remember(Category::CACHE_KEY,   now()->addMinutes(1) , function () {
          return Category::with('subcategories')->get();

      });
     // return Category::with('subcategories')->get();

    }
}



if (!function_exists('getWishlist')) {
    function getWishlist()
    {
        return session()->get('wishlist', []);
    }
}
if (!function_exists('getCourseCategories')) {
    function getCourseCategories()
    {
        return session()->get('getCourseCategories', []);
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

 
