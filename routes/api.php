<?php

use App\Http\Controllers\CheckOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    //payment test config
    Route::post('check-otp', \CheckOtp::class);
    Route::get('get-payment-status','PaymentController@checkPaymentStatus');
    Route::post('/course-payment','PaymentController@coursePayment');
    Route::post('course/add-to-fav','CourseController@addToFavourite');
    Route::post('article/add-to-fav','CourseController@addToFavourite');
    Route::post('courses/free-course','PaymentController@joinFreeCourse');
    Route::post('course/get-course-quize','QuizController@getUserCourseQuiz');
    
    Route::post('course/user-complete-quize','QuizController@completeQuiz');




    // check user promo code
    Route::post('/check-promocode','PromoCodeController@checkPromoCode');

    // ckeditor upload images

    Route::post('ckeditor/upload-image','HomeController@ckUploadImages');

    //admin routes

    Route::group(['prefix' => 'admin', 'middleware' => ['isAdmin']], function(){

        // contact us
        Route::get('/contact-us/all-messages','ContactUsController@index');
        Route::get('/contact-us/{id}','ContactUsController@show');



        //users
        Route::post('/delete-user/{id}','UserController@delete');
        Route::post('/user-status/{id}','UserController@changeStatus');
        Route::get('/get-all-users','UserController@getAllUsers');

        // parent route
        Route::get('get-parents-data','ParentUsersController@getParentsData');
        Route::get('parent/{id}','ParentUsersController@show');
        Route::post('/parent/update/{id}','ParentUsersController@update');
        Route::post('/parent/create','ParentUsersController@create');

        //specialist route
        Route::get('get-specialists-data','SpecialistController@getSpecialistsData');
        Route::get('specialist/{id}','SpecialistController@show');
        Route::post('specialist/update/{id}','SpecialistController@update');
        Route::post('/specialist/create','SpecialistController@createSpecAdmin');

        //other route
        Route::get('get-others-data','OthersController@getOthersData');
        Route::get('other/{id}','OthersController@show');
        Route::post('other/update/{id}','OthersController@update');
        Route::post('/other/create','OthersController@createOtherAdmin');

        // course route
        Route::get('course-init-data','CourseController@getCoursesInitData');
        Route::post('storeCourseInfo','CourseController@storeCourseInfo');
        Route::get('/getCourseVideos/{course_id}','CourseController@getCourseVideos');
        Route::get('uploadVideos/{id}','CourseController@uploadVideos');
        Route::post('/course/upload-video','CourseController@UploadCourseVideo');
        Route::get('/onlineCourse','CourseController@index');
        Route::get('/edit-course/{course_id}','CourseController@getCoruseInfo')->name('getCoruseInfo');
        Route::post('/edit-course/{course_id}','CourseController@updateCoruseInfo');
        Route::post('/delete-course','CourseController@deleteCourse');
        Route::post('/course-preview/{course_id}','CourseController@preview');
        Route::get('/course-certificate/{id}','CourseController@certificate');
        Route::post('/course/update-video/{id}','CourseController@updateVideo');

        // media

        Route::post('/create-media','MediaController@create');
        Route::get('/media','MediaController@index');

        // quize
        Route::get('/get-quiz/{id}','QuizController@getCourseQuiz');
        Route::post('/edit-answer/{id}','QuizController@editAnswer')->name('editAnswer');
        Route::post('/question-status/{id}','QuizController@changeQuestionStatus');
        Route::post('/question-delete/{id}','QuizController@deleteQuestion');
        Route::post('/question-store','QuizController@storeQuestion')->name('question.store');
        Route::post('/set-correct-answer/{id}','QuizController@setCorrectAnswer')->name('setCorrectAnswer');

        // coupons
        Route::get('/coupons','PromoCodeController@index');
        Route::post('/coupon/create','PromoCodeController@create');
        Route::get('/coupons/{id}','PromoCodeController@show');
        Route::post('/coupon/assign-to-users','PromoCodeController@assignToUsers');
        Route::post('/coupon/edit/{id}','PromoCodeController@update');
        Route::post('/delete-coupon/{id}','PromoCodeController@delete');
        Route::post('/change-coupon-status/{id}','PromoCodeController@changeStatus');

        // calls
        Route::get('/calls/packages','CallsController@index');
        Route::post('/calls/create','CallsController@create');
        Route::get('/calls/package/{id}','CallsController@show');
        Route::post('/calls/package/{id}','CallsController@update');
        Route::post('/change-call-package-status/{id}','CallsController@changeStatus');
        Route::post('/delete-call-package/{id}','CallsController@delete');

        //orders
        Route::get('/orders/courses','PaymentController@index')->name('index.orders'); // will moved to CoursespurchaseordersController
        Route::post('/orders-courses/export-to-excel','CoursespurchaseordersController@exportToExcel')->name('create.others');

        // courses
        Route::match(['get','post'],'/course/course-lectures','CourseController@getClassRoomLectures');

        // contents
        Route::get('/contents','ContentController@index');
        Route::get('/content/{id}','ContentController@update');


    });
    Route::match(['post'],'/course/course-lectures','CourseController@getClassRoomLectures');
    Route::post('/course/video-actions','UserController@setVideoActions');

    // general routes
    Route::get('get-profile-data','UserController@getUserData');
    // Route::post('logoutt','AuthController@logout')->name('user.logoutt');
    Route::post('/store-user-interests','UserInterestsController@store')->name('store.interests');
    route::post('set-new-password','UserController@setNewPassword');
    Route::post('/edit-profile-image','UserController@editProfileImage');
    Route::get('/courses/get-user-courses','UserController@userCourses');

    // parent routes
    Route::post('/parent-complete-register','ParentUsersController@completeRegister');
    Route::post('/edit-parent-profile-data','ParentUsersController@editProfileData');
    Route::post('/set-private-mode','ParentUsersController@setPrivateMode');

    // speciaist route
    Route::post('/specialist-complete-register','SpecialistController@create')->name('create.specialist');
    Route::post('/edit-specialist-profile-data','SpecialistController@editProfileData');

    // others route
    Route::post('/other-complete-register','OthersController@create');
    Route::post('/edit-other-profile-data','OthersController@editProfileData');
    Route::post('/course-payment','PaymentController@coursePayment');





});

// non auth routes
Route::post('register','AuthController@signup')->name('user.register');
Route::post('login','AuthController@login')->name('user.login');
Route::get('all-courses','CourseController@getAllcourses')->name('getAllcourses');
Route::get('get-categories','CategoriesController@index');
Route::get('/check-user-authentication',CheckUserAuth::class);
Route::post('/payment/course','PaymentController@coursePaymentCallback');
Route::post('/user/forget-password','HomeController@forgetPassword');
Route::post('/user/forget-password/check-otp','HomeController@checkForgetPassword');
Route::post('/user/forget-password/change-password','HomeController@changePassword');
Route::get('/contents','ContentController@index');
Route::post('/contact-us','ContactUsController@contactUs');
Route::post('/show-article','ContentController@showArticle');
Route::get('/media','MediaController@index');






