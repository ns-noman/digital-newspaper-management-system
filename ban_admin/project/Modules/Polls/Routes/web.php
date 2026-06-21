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

Route::prefix('polls')->group(function() {
    Route::get('/', 'PollsController@index')->name('Polls');
    Route::post('/store', 'PollsController@store')->name('Polls Store');
    Route::post('/update', 'PollsController@update')->name('Polls Update');
    Route::get('/delete/{id}', 'PollsController@destroy')->name('Polls Delete');
    Route::post('/bulkupdate', 'PollsController@bulkUpdate')->name('Polls Bulk Update');
});
