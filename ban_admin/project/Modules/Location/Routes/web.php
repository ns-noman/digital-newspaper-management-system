<?php

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

Route::prefix('location')->group(function() {
    Route::get('/', 'LocationController@index')->name('Location');
    Route::post('/store', 'LocationController@store')->name('Location Store');
    Route::post('/update', 'LocationController@update')->name('Location Update');
    Route::get('/delete/{id}', 'LocationController@destroy')->name('Location Delete');
    Route::post('/bulkupdate', 'LocationController@bulkUpdate')->name('Location Bulk Update');
    ## ajax routes ##
    Route::get('/ajax/load/districts/{division}', 'LocationController@ajaxGetDistricts')->where('division', '[0-9]+');
});

