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

Route::prefix('archivedtopics')->group(function() {
    Route::get('/', 'ArchivedTopicsController@index')->name('ArchivedTopics');
	Route::post('/store', 'ArchivedTopicsController@store')->name('ArchivedTopics Store');
	Route::post('/update', 'ArchivedTopicsController@update')->name('ArchivedTopics Update');
	Route::get('/delete/{id}', 'ArchivedTopicsController@destroy')->name('ArchivedTopics Delete');
	Route::post('/bulkupdate', 'ArchivedTopicsController@bulkUpdate')->name('ArchivedTopics Bulk Update');
});
