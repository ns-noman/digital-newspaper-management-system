<?php

use Illuminate\Support\Facades\Route;

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

## artisan command
Route::get('/clear-all', function() {
	$exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('cache:clear'); 
    $exitCode = Artisan::call('config:clear');
    return 'Clear and Config All';
});

## login
Route::get('/', function () {
    if(Auth::user()){
      return redirect('/dashboard');
  }else{
      return redirect('/login');
  }
});

## Authentication
Auth::routes(['register' => false, 'reset' => false]);
Route::group(['middleware' => ['auth']], function () {

    ## dashboard
    Route::get('dashboard', 'App\Http\Controllers\DashboardController@index');
    Route::get('ajax/todayshit', 'App\Http\Controllers\DashboardController@getTodaysHit');

    Route::get('ajax/get/topic/', 'App\Http\Controllers\CommonController@ajaxGetTopic');
    Route::get('ajax/get/newsurl/{newsId}/', 'App\Http\Controllers\CommonController@ajaxGetNewsUrl');
    Route::get('ajax/get/districts/{id}/', 'App\Http\Controllers\CommonController@ajaxGetDistricts');
    Route::get('ajax/get/upazilas/{id}/', 'App\Http\Controllers\CommonController@ajaxGetUpazilas');
    Route::get('ajax/remove/thumbnail/{articleId}', 'App\Http\Controllers\CommonController@removeThumbnail');
    Route::get('ajax/remove/imgageInfo/{photoId}', 'App\Http\Controllers\CommonController@removeImageInfo');   
    Route::post('ajax/text-editor/image', 'App\Http\Controllers\CommonController@textEditorImageUpload');
    Route::post('ajax/text-editor/image/edit', 'App\Http\Controllers\CommonController@textEditorImageUploadedit');

    Route::get('/users/profile', 'App\Http\Controllers\CommonController@profile')->name('Users Profile');
    Route::post('/users/profile/update', 'App\Http\Controllers\CommonController@profileUpdate')->name('Users Profile Update');

    
    Route::group(['middleware' => 'role'], function() {
        ## Category
        Route::get('category', 'App\Http\Controllers\CategoryController@index');
        Route::get('ajax/upCategory/{id}', 'App\Http\Controllers\CategoryController@upCategory');
        Route::get('ajax/downCategory/{id}', 'App\Http\Controllers\CategoryController@downCategory');
        Route::get('ajax/category/edit/{id}', 'App\Http\Controllers\CategoryController@edit');
        Route::post('category/store', 'App\Http\Controllers\CategoryController@store');
        Route::post('category/update', 'App\Http\Controllers\CategoryController@update');
    });

});


