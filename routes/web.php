
<?php

use \App\Http\Controllers\Dashboard\Instructor\Course\CourseSectionController;
use \App\Http\Controllers\Dashboard\Instructor\QuestionController;
use \App\Http\Controllers\Dashboard\Instructor\QuizController;
use \App\Http\Controllers\Dashboard\Instructor\ZoomMeetingController;
use \App\Http\Controllers\Dashboard\Student\StudentQuizController;
use App\Http\Controllers\Dashboard\Admin\AdminController;
use App\Http\Controllers\Dashboard\Admin\AdminInstractor;
use App\Http\Controllers\Dashboard\Admin\CartController;
use App\Http\Controllers\Dashboard\Admin\Category\CategoryController;
use App\Http\Controllers\Dashboard\Admin\Category\SubCategoryController;
use App\Http\Controllers\Dashboard\Admin\CourseAdminController;
use App\Http\Controllers\Dashboard\Admin\Info\InfoController;
use App\Http\Controllers\Dashboard\Admin\OrderAdminController;
use App\Http\Controllers\Dashboard\Admin\SettingController;
use App\Http\Controllers\Dashboard\Admin\Slider\SliderController;
use App\Http\Controllers\Dashboard\Instructor\CouponController;
use App\Http\Controllers\Dashboard\Instructor\Course\CourseController;
use App\Http\Controllers\Dashboard\Instructor\Course\CourseLectureController;
use App\Http\Controllers\Dashboard\Instructor\InstructorController;
use App\Http\Controllers\Dashboard\Instructor\StudentController;
use App\Http\Controllers\Dashboard\Student\StudentCourseController;
use App\Http\Controllers\Dashboard\User\CheckoutController;
use App\Http\Controllers\Dashboard\User\OrderController;
use App\Http\Controllers\Dashboard\User\SocialController;
use App\Http\Controllers\Dashboard\User\UserDashboardController;
use App\Http\Controllers\Dashboard\User\WhishlistController;
use App\Http\Controllers\Site\FrontendDashboardController;
use App\Models\Course;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\In;











Route::get('/dashboard', function () {

    return redirect()->to('admin/login');
})->middleware('guest');;





Route::group([
    'prefix' => 'admin/dashboard',
    'as' => 'admin.',
    'middleware' => ['auth:admin', 'verified'],
], function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    Route::get('profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('profile', [AdminController::class, 'updateProfile'])->name('profile.store');
    Route::get('settings', [AdminController::class, 'setting'])->name('setting');
    Route::post('passwordSetting', [AdminController::class, 'resetPassword'])->name('passwordSetting');
    Route::resource('category', CategoryController::class);
    Route::resource('subcategory', SubCategoryController::class);
    Route::resource('slider', SliderController::class);
    Route::resource('info', InfoController::class);
    Route::resource('instructor', AdminInstractor::class);
    Route::post('update-status', [AdminInstractor::class, 'updateStatus'])->name('instructor.status');
    Route::get('instructor-active-list', [AdminInstractor::class, 'activeList'])->name('instructor.active');

    Route::get('stripe-setting', [SettingController::class, 'stripSetting'])->name('stripSetting');
    Route::post('stripe-setting/update', [SettingController::class, 'stripSettingUpdate'])->name('stripe.settings.update');

    Route::get('site-setting/index', [AdminController::class, 'siteSetting'])->name('site-setting.index');

    Route::resource('course', CourseAdminController::class);
    Route::post('/course-status', [CourseAdminController::class, 'courseStatus'])->name('course.status');
    Route::resource('order', OrderAdminController::class);
    Route::get('/google-setting', [SettingController::class, 'googleSetting'])->name('googleSetting');
    Route::post('/google-settings/update', [SettingController::class, 'updateGoogleSettings'])->name('google.settings.update');
});



Route::group([
    'prefix' => 'instructor/dashboard',
    'as' => 'instructor.',
    'middleware' => ['auth:instructor', 'verified'],
], function () {
    Route::get('/', [InstructorController::class, 'index'])->name('dashboard');
    Route::post('/logout', [InstructorController::class, 'logout'])->name('logout');
    Route::get('profile', [InstructorController::class, 'profile'])->name('profile');
    Route::post('profile', [InstructorController::class, 'updateProfile'])->name('profile.store');
    Route::get('settings', [InstructorController::class, 'setting'])->name('setting');
    Route::post('passwordSetting', [InstructorController::class, 'resetPassword'])->name('passwordSetting');
    Route::post("instructor/register", [InstructorController::class, 'instructorRegister'])->name('register');

    Route::resource('course', CourseController::class);
    Route::get('get-subcategories/{category_id}', [CourseController::class, 'getSubcategories'])->name('get-subcategories');

    Route::resource("course-section", CourseSectionController::class);
    Route::resource("lecture", CourseLectureController::class);
    Route::resource("coupon", CouponController::class);
    Route::resource('student', StudentController::class);
    Route::resource('quiz', QuizController::class);
    Route::resource('zoom-meeting', ZoomMeetingController::class)->only(['index', 'create', 'store', 'edit', 'update']);

    // Question Routes
    Route::get('/quiz/{quiz_id}/questions', [QuestionController::class, 'index'])->name('question.index');
    Route::get('/quiz/{quiz_id}/questions/create', [QuestionController::class, 'create'])->name('question.create');
    Route::post('/question/store', [QuestionController::class, 'store'])->name('question.store');
    Route::get('/question/{id}/edit', [QuestionController::class, 'edit'])->name('question.edit');
    Route::post('/question/{id}/update', [QuestionController::class, 'update'])->name('question.update');
    Route::delete('/question/{id}/delete', [QuestionController::class, 'destroy'])->name('question.destroy');
    Route::post('student/status', [StudentController::class, 'updateStatus'])->name('student.status');
    Route::get('student/{id}/courses', [StudentController::class, 'getStudentCourses'])->name('student.get.courses');
    Route::get('/quiz/{id}/attempts', [QuizController::class, 'attempts'])->name('quiz.attempts');
});



Route::get('/', [FrontendDashboardController::class, 'index'])->name('frontend.home');
Route::get('course-details/{slug}', [FrontendDashboardController::class, 'courseDetails'])->name('course-details');
Route::post('wishlist/add', [WhishlistController::class, 'addToWhishlist'])->name('addToWhishlist');
Route::get('wishlist/all', [WhishlistController::class, 'allWhishlist'])->name('allWhishlist');
Route::get('cart', [CartController::class, 'index'])->name('cart');
Route::post('cart/add', [CartController::class, 'addToCart'])->name('cart.add')->middleware('auth:web');
Route::get('fetch/cart', [CartController::class, 'getCartItem'])->name('cart.fetch')->middleware('auth:web');
Route::get('cart/all', [CartController::class, 'getAllCart'])->name('cart.all');
Route::delete('cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/remove/cart', [CartController::class, 'removeCartItem'])->name('cart.remove');



////*********************************Checkout************************ */
Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index')->middleware('auth:web');
////*********************************End-Checkout************************ */

/// ********************************coupon **********************************************
Route::post("apply-coupon", [CouponController::class, 'applyCoupon'])->name('apply-coupon');
Route::post("apply-checkout-coupon", [CouponController::class, 'applyCheckoutCoupon'])->name('checkoutCoupon');
////*********************************End-coupon************************ */
/*  Google Route  */

Route::get('auth/google', [SocialController::class, 'googleLogin'])->name('auth.google');
Route::get('/auth/google/callback', [SocialController::class, 'googleAuthentication'])
    ->name('auth.google-callback');

/// ********************************order**********************************************
Route::group(['middleware' => ['auth:web']], function () {
    Route::post("order", [OrderController::class, 'order'])->name('order');
    Route::get("success", [OrderController::class, 'success'])->name('success');

    // Student Quiz Routes
    Route::controller(StudentQuizController::class)->group(function () {
        Route::get('/student/my-quizzes', 'myQuizzes')->name('student.my.quizzes');
        Route::get('/student/course/{course_id}/quizzes', 'index')->name('student.course.quizzes');
        Route::get('/student/quiz/{id}', 'show')->name('student.quiz.show');
        Route::post('/student/quiz/{id}/submit', 'submit')->name('student.quiz.submit');
    });
    Route::get("payment-cancel", [OrderController::class, 'cancel'])->name('cancel');
});
////*********************************End-order************************ */


Route::group([
    'prefix' => 'user/dashboard',
    'as' => 'user.',
    'middleware' => ['auth:web'],
], function () {
    Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserDashboardController::class, 'profile'])->name('profile');
    Route::post('/profile/store', [UserDashboardController::class, 'profileStore'])->name('profile.store');
    Route::post('/user/passwordSetting', [UserDashboardController::class, 'resetPassword'])->name('passwordSetting');
    Route::post('/logout', [UserDashboardController::class, 'logout'])->name('logout');
    Route::get('wishlist', [WhishlistController::class, 'index'])->name('wishlist.index');
    Route::get('wishlist-data', [WhishlistController::class, 'getWishlist'])->name('getWishlist');
    Route::delete('wishlist/{id}', [WhishlistController::class, 'destroy'])->name('deleteWishlist');
    Route::get('course', [StudentCourseController::class, 'index'])->name('course.index');
    Route::get('course/{id}', [StudentCourseController::class, 'show'])->name('course.show');

    //course video show
    Route::get('/course/video/{lecture}', [StudentCourseController::class, 'showVideo'])
        ->name('course.video')
        ->middleware('auth:web'); // بس للمستخدمين المسجلين
    //end course show



});
