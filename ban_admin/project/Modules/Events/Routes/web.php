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

Route::prefix('events')->group(function() {
    Route::get('/', 'EventsController@index')->name('Events');
    Route::post('/store', 'EventsController@store')->name('Events Store');
    Route::post('/update', 'EventsController@update')->name('Events Update');
    Route::get('/delete/{id}', 'EventsController@destroy')->name('Events Delete');
    Route::post('/bulkupdate', 'EventsController@bulkUpdate')->name('Events Bulk Update');
    Route::get('/news/{event_id}', 'EventsController@eventNews')->name('Events News');
    Route::post('/news/bulkupdate', 'EventsController@eventNewsBulkUpdate')->name('Events News Bulk Update');
});
