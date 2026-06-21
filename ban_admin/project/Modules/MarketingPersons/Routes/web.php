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

Route::prefix('marketingpersons')->group(function() {
    Route::get('/', 'MarketingPersonsController@index')->name('MarketingPersons');
	Route::post('/store', 'MarketingPersonsController@store')->name('MarketingPersons Store');
	Route::post('/update', 'MarketingPersonsController@update')->name('MarketingPersons Update');
	Route::get('/delete/{id}', 'MarketingPersonsController@destroy')->name('MarketingPersons Delete');
	Route::post('/bulkupdate', 'MarketingPersonsController@bulkUpdate')->name('MarketingPersons Bulk Update');
});
