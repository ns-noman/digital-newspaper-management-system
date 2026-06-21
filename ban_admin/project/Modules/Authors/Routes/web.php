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

Route::prefix('authors')->group(function() {
    Route::get('/', 'AuthorsController@index')->name('Authors');
	Route::post('/store', 'AuthorsController@store')->name('Authors Store');
	Route::post('/update', 'AuthorsController@update')->name('Authors Update');
	Route::get('/delete/{id}', 'AuthorsController@destroy')->name('Authors Delete');
	Route::post('/bulkupdate', 'AuthorsController@bulkUpdate')->name('Authors Bulk Update');
});
