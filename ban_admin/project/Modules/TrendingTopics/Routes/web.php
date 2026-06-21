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

Route::prefix('trendingtopics')->group(function() {
    Route::get('/', 'TrendingTopicsController@index')->name('TrendingTopics');
	Route::post('/store', 'TrendingTopicsController@store')->name('TrendingTopics Store');
	Route::post('/update', 'TrendingTopicsController@update')->name('TrendingTopics Update');
	Route::get('/delete/{id}', 'TrendingTopicsController@destroy')->name('TrendingTopics Delete');
	Route::post('/bulkupdate', 'TrendingTopicsController@bulkUpdate')->name('TrendingTopics Bulk Update');
});
