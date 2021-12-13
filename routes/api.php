<?php

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

// Route::group(['middleware' => 'auth:api'], function () {
//     Route::post('storeCourseInfo','CourseController@storeCourseInfo')->name('storeCourseInfo');

// });
// Route::group(['prefix' => 'auth'], function () {
//     Route::post('user/login', 'AuthController@login');
//     Route::post('signup', 'AuthController@signup');

//     Route::group(function() {
//         Route::get('logout', 'AuthController@logout');
//         Route::get('user', 'AuthController@user');
//         Route::middleware('auth:api')->get('user','AuthController@user');
//         Route::post('course/storeCourseInfo','CourseController@storeCourseInfo')->name('course.storeCourseInfo');

//     });
// });
// Route::middleware('auth:sanctum')->group(function () {

// });

// route::middleware('auth:sanctum')->get('/user',function(Request $request){
//     dd($request->user());
//     return $request->user();
// });

Route::get('/check-user-authentication',CheckUserAuth::class);
Route::middleware('auth:sanctum')->group(function () {

    //admin routes
    Route::group(['prefix' => 'admin', 'middleware' => ['isAdmin']], function(){

       // parent route
        Route::get('get-parents-data','ParentUsersController@getParentsData');
        Route::get('parent/{id}','ParentUsersController@show');
        Route::post('admin/parent/update/{id}','ParentUsersController@update');

        //specialist route
        Route::get('get-specialists-data','SpecialistController@getSpecialistsData');
        Route::get('specialist/{id}','SpecialistController@show');
        Route::post('admin/specialist/update/{id}','SpecialistController@update');

        //other route
        Route::get('get-others-data','OthersController@getOthersData');
        Route::get('other/{id}','OthersController@show');
        Route::post('other/update/{id}','OthersController@update');

        // course route
        Route::get('course-init-data','CourseController@getCoursesInitData');
        Route::post('storeCourseInfo','CourseController@storeCourseInfo');
        Route::get('/getCourseVideos/{course_id}','CourseController@getCourseVideos');
        Route::get('uploadVideos/{id}','CourseController@uploadVideos');
        Route::post('/course/upload-video','CourseController@UploadCourseVideo');
        Route::get('/onlineCourse','CourseController@index');







    });

    // general routes
    Route::get('get-profile-data','UserController@getUserData');
    Route::post('logoutt','AuthController@logout')->name('user.logoutt');
    Route::post('/store-user-interests','UserInterestsController@store')->name('store.interests');
    route::post('set-new-password','UserController@setNewPassword');
    Route::post('/edit-profile-image','UserController@editProfileImage');
    Route::get('all-courses','CourseController@getAllcourses')->name('getAllcourses');





    // parent routes
    Route::post('/parent-complete-register','ParentUsersController@completeRegister');
    Route::post('/edit-parent-profile-data','ParentUsersController@editProfileData');
    Route::post('/set-private-mode','ParentUsersController@setPrivateMode');

    // speciaist route
    Route::post('/specialist-complete-register','SpecialistController@create')->name('create.specialist');
    Route::post('/edit-specialist-profile-data','SpecialistController@editProfileData');


    // others route
    Route::post('/other-complete-register','OthersController@create')->name('create.others');
    Route::post('/edit-other-profile-data','OthersController@editProfileData');


});

Route::post('register','AuthController@signup')->name('user.register');
Route::post('login','AuthController@login')->name('user.login');
