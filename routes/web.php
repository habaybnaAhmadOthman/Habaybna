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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/check-otp', 'HomeController@checkOtp')->name('check-otp'); //->withoutMiddleware(IsVerified::class);
Route::post('/check-otp', 'HomeController@otpValidate')->name('otp-validate');


//patents route
Route::middleware([IsParent::class])->group(function () {
    Route::post('/complete-register','ParentUsersController@completeRegister')->name('parent.completeRegister')->middleware(IsVerified::class);
Route::get('/complete-register','ParentUsersController@completeRegister')->name('parent.completeRegister')->middleware(IsVerified::class);
Route::view('/complete-register', 'parents.completeRegister');
Route::view('/parent-dashboard','parents.parentDashboard')->middleware(IsVerified::class);

    });






// admin

Route::prefix('admin')->middleware([IsAdmin::class])->group(function () {

    // dashboard
    Route::view('/','admin.adminDashboard');

    // courses

    Route::get('/onlineCourse','CourseController@index')->name('onlineCourse');
    Route::get('course/create','CourseController@create')->name('course.create');

    // courses categories

    Route::get('/coursesCategories','CoursesCategoriesController@index')->name('coursesCategories');
    Route::get('category/create','CoursesCategoriesController@create')->name('category.create');
    Route::post('category/store','CoursesCategoriesController@store')->name('category.store');
    Route::get('category/{id}/edit','CoursesCategoriesController@edit')->name('category.edit');
    Route::post('category/update/{id}','CoursesCategoriesController@update')->name('category.update');

    });
