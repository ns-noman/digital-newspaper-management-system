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

Route::prefix('popularnews')->group(function() {
    Route::get('/', 'PopularNewsController@index')->name('PopularNews');
	Route::post('/store', 'PopularNewsController@store')->name('PopularNews Store');
	Route::post('/update', 'PopularNewsController@update')->name('PopularNews Update');
	Route::get('/delete/{id}', 'PopularNewsController@destroy')->name('PopularNews Delete');
	Route::post('/bulkupdate', 'PopularNewsController@bulkUpdate')->name('PopularNews Bulk Update');

	Route::get('/pull/ga-data', 'PopularNewsController@pullGoogleAnalyticsData')->name('PopularNews Pull GA Data');
});
