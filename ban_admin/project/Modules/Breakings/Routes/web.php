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

Route::prefix('breakings')->group(function() {
    Route::get('/', 'BreakingsController@index')->name('Breakings');
    Route::post('/store', 'BreakingsController@store')->name('Breakings Store');
    Route::post('/update', 'BreakingsController@update')->name('Breakings Update');
    Route::get('/delete/{id}', 'BreakingsController@destroy')->name('Breakings Delete');
    Route::post('/bulkupdate', 'BreakingsController@bulkUpdate')->name('Breakings Bulk Update');
});
