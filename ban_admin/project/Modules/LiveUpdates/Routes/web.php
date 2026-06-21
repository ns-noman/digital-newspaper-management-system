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

Route::prefix('liveupdates')->group(function() {
    Route::get('/', 'LiveUpdatesController@index')->name('LiveUpdates');
	Route::post('/store', 'LiveUpdatesController@store')->name('LiveUpdates Store');
	Route::post('/update', 'LiveUpdatesController@update')->name('LiveUpdates Update');
	Route::get('/delete/{id}', 'LiveUpdatesController@destroy')->name('LiveUpdates Delete');
	Route::post('/bulkupdate', 'LiveUpdatesController@bulkUpdate')->name('LiveUpdates Bulk Update');
});
