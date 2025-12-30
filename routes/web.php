
<?php

use App\Http\Controllers\Dashboard\Admin\AdminController;
use App\Http\Controllers\Dashboard\Admin\AdminInstractor;
use App\Http\Controllers\Dashboard\Admin\Category\CategoryController;
use App\Http\Controllers\Dashboard\Admin\Category\SubCategoryController;
use App\Http\Controllers\Dashboard\Admin\Info\InfoController;
use App\Http\Controllers\Dashboard\Admin\Slider\SliderController;
use App\Http\Controllers\Dashboard\Instructor\Course\CourseController;
use App\Http\Controllers\Dashboard\Instructor\InstructorController;
use App\Http\Controllers\Site\FrontendDashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\In;

Route::get('/dashboard', function () {
  
    return redirect()->to('admin/login');

})->middleware('guest');
;


Route::group([
    'prefix' => 'admin/dashboard',
    'as' => 'admin.',
     'middleware' => ['auth:admin','verified'], 
], function () {
   Route::get('/', [AdminController::class, 'index'])->name('dashboard');
   Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
   Route::get('profile',[AdminController::class,'profile'])->name('profile');
   Route::post('profile',[AdminController::class,'updateProfile'])->name('profile.store');
   Route::get('settings',[AdminController::class,'setting'])->name('setting');
   Route::post('passwordSetting',[AdminController::class,'resetPassword'])->name('passwordSetting');
   Route::resource('category', CategoryController::class);
   Route::resource('subcategory', SubCategoryController::class);
   Route::resource('slider', SliderController::class);
   Route::resource('info', InfoController::class);
   Route::resource('instructor', AdminInstractor::class);
   Route::post('update-status',[AdminInstractor::class,'updateStatus'])->name('instructor.status');
   Route::get('instructor-active-list',[AdminInstractor::class,'activeList'])->name('instructor.active');


   
});


Route::group([
    'prefix' => 'instructor/dashboard',
    'as' => 'instructor.',
     'middleware' => ['auth:instructor','verified'], 
], function () {
   Route::get('/', [InstructorController::class, 'index'])->name('dashboard');
   Route::post('/logout', [InstructorController::class, 'logout'])->name('logout');
   Route::get('profile',[InstructorController::class,'profile'])->name('profile');
   Route::post('profile',[InstructorController::class,'updateProfile'])->name('profile.store');
   Route::get('settings',[InstructorController::class,'setting'])->name('setting');
   Route::post('passwordSetting',[InstructorController::class,'resetPassword'])->name('passwordSetting');
   Route::post("instructor/register", [InstructorController::class, 'instructorRegister'])->name('register');

   Route::resource('course', CourseController::class);
   Route::get('get-subcategories/{category_id}', [CourseController::class, 'getSubcategories'])->name('get-subcategories');
   Route::get('get-course-section', [CourseController::class, 'getSubcategories'])->name('course-section.show');
});



Route::get('/',[FrontendDashboardController::class, 'index'])->name('frontend.home');
Route::get('sx',[FrontendDashboardController::class, 'ss'])->name('cart');