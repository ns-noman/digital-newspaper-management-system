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

Route::prefix('incidents')->group(function() {
	Route::get('/', 'IncidentsController@index')->name('Incidents');
	Route::post('/store', 'IncidentsController@store')->name('Incidents Store');
	Route::post('/update', 'IncidentsController@update')->name('Incidents Update');
	Route::get('/delete/{id}', 'IncidentsController@destroy')->name('Incidents Delete');
	Route::post('/bulkupdate', 'IncidentsController@bulkUpdate')->name('Incidents Bulk Update');
});
