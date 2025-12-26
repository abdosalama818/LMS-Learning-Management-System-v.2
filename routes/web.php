<?php

use App\Http\Controllers\Dashboard\Admin\AdminController;
use App\Http\Controllers\Dashboard\Admin\Category\CategoryController;
use App\Http\Controllers\Dashboard\Admin\Category\SubCategoryController;
use App\Http\Controllers\Dashboard\Instructor\InstructorController;
use Illuminate\Support\Facades\Route;




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
   
});

