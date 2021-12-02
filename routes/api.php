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

Route::middleware('auth:sanctum')->group(function () {

    // general routes
    route::get('get-profile-data','UserController@getUserData');
    Route::post('logoutt','AuthController@logout')->name('user.logoutt');
    Route::post('/store-user-interests','UserInterestsController@store')->name('store.interests');
    route::post('set-new-password','UserController@setNewPassword');



    // parent routes
    Route::post('/parent-complete-register','ParentUsersController@completeRegister');
    Route::post('/edit-parent-profile-data','ParentUsersController@editProfileData');
    Route::post('/set-private-mode','ParentUsersController@setPrivateMode');

    // speciaist route
    Route::post('/specialist-complete-register','SpecialistController@create')->name('create.specialist');

    // others route
    Route::post('/other-complete-register','OthersController@create')->name('create.others');

});

Route::post('register','AuthController@signup')->name('user.register');
Route::post('login','AuthController@login')->name('user.login');
