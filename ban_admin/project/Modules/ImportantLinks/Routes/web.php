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

Route::prefix('importantlinks')->group(function() {
    Route::get('/', 'ImportantLinksController@index')->name('ImportantLinks');
	Route::post('/store', 'ImportantLinksController@store')->name('ImportantLinks Store');
	Route::post('/update', 'ImportantLinksController@update')->name('ImportantLinks Update');
	Route::get('/delete/{id}', 'ImportantLinksController@destroy')->name('ImportantLinks Delete');
	Route::post('/bulkupdate', 'ImportantLinksController@bulkUpdate')->name('ImportantLinks Bulk Update');
});
