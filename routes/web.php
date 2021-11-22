<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsVerified;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsParent;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('login', 'AuthController@loginPage')->name('loginPage');
// Route::post('login', 'AuthController@login')->name('loginn');
Route::post('logoutt', 'AuthController@logout')->name('logoutt');
// Route::post('signup', 'AuthController@signup');

Auth::routes();
    Route::view('/','welcome');

// Route::view('xxxxx','auth.register');

// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/check-otp', 'HomeController@checkOtp')->name('check-otp'); //->withoutMiddleware(IsVerified::class);
// Route::post('/check-otp', 'HomeController@otpValidate')->name('otp-validate');
Route::get('/get-user-country','HomeController@getUserCountry');

//patents route
// Route::middleware([IsParent::class])->group(function () {
    Route::post('/parent-complete-register','ParentUsersController@completeRegister')->name('parent.completeRegister')->middleware(IsVerified::class);
    Route::get('/complete-register','ParentUsersController@completeRegister')->name('parent.completeRegister')->middleware(IsVerified::class);
    Route::view('/complete-register', 'parents.completeRegister');
    Route::view('/parent-dashboard','parents.parentDashboard')->middleware(IsVerified::class);
    Route::get('/parent/all-courses','CourseController@getAllcourses')->name('getAllcourses');
    Route::view('/parent-dashboard/class-room/{id}', 'parents.classRoom');
    Route::get('/parent/getCourseVideos/{course_id}','CourseController@getCourseAndVideos')->name('parent.getCourseVideos');



    // });

    // specialist
    Route::post('/specialist-complete-register','SpecialistController@create')->name('create.specialist');

    //others
    



    // admin

Route::prefix('admin')->middleware(['auth', IsAdmin::class])->group(function () {

    // dashboard
    Route::view('/','admin.adminDashboard');

    // courses

    Route::get('/onlineCourse','CourseController@index')->name('onlineCourse');
    // Route::get('course/create','CourseController@create')->name('course.create');
    // Route::any('/{any}','CourseController@create')->name('course.any');
    // Route::get('course/create','CourseController@create')->name('course.create');
    Route::post('storeCourseInfo','CourseController@storeCourseInfo')->name('storeCourseInfo');
    Route::post('/course/upload-video','CourseController@UploadCourseVideo')->name('UploadCourseVideo');
    Route::post('/course/update-video/{id}','CourseController@updateVideo')->name('updateVideo');
    // Route::get('uploadVideos/{id}','CourseController@uploadVideos')->name('uploadVideos');
     Route::get('course-category','CourseController@getCoursesCategories')->name('getCoursesCategories');
     Route::get('/getCourseVideos/{course_id}','CourseController@getCourseVideos')->name('getCourseVideos');
     Route::get('/edit-course/{course_id}','CourseController@getCoruseInfo')->name('getCoruseInfo');
     Route::post('/edit-course/{course_id}','CourseController@updateCoruseInfo')->name('updateCoruseInfo');

    Route::post('/question-store','CourseController@storeQuestion')->name('question.store');
    Route::post('/set-correct-answer/{id}','CourseController@setCorrectAnswer')->name('setCorrectAnswer');
    Route::get('/get-quiz/{id}','CourseController@getQuiz')->name('getQuiz');
    Route::post('/edit-answer/{id}','CourseController@editAnswer')->name('editAnswer');


    // courses categories

    Route::get('/coursesCategories','CoursesCategoriesController@index')->name('coursesCategories');
    Route::get('category/create','CoursesCategoriesController@create')->name('category.create');
    Route::post('category/store','CoursesCategoriesController@store')->name('category.store');
    Route::get('category/{id}/edit','CoursesCategoriesController@edit')->name('category.edit');
    Route::post('category/update/{id}','CoursesCategoriesController@update')->name('category.update');
    Route::view('{any}','admin.adminDashboard')->where('any','.*');
    });

    Route::view('{any}','welcome')->where('any','.*');
