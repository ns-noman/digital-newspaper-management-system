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

Route::prefix('employeeinitials')->group(function() {
    Route::get('/', 'EmployeeInitialsController@index')->name('EmployeeInitials');
	Route::post('/store', 'EmployeeInitialsController@store')->name('EmployeeInitials Store');
	Route::post('/update', 'EmployeeInitialsController@update')->name('EmployeeInitials Update');
	Route::get('/delete/{id}', 'EmployeeInitialsController@destroy')->name('EmployeeInitials Delete');
	Route::post('/bulkupdate', 'EmployeeInitialsController@bulkUpdate')->name('EmployeeInitials Bulk Update');

	Route::get('/type', 'EmployeeInitialsTypeController@index')->name('EmployeeInitials Type');
	Route::post('/type/store', 'EmployeeInitialsTypeController@store')->name('EmployeeInitials Type Store');
	Route::post('/type/update', 'EmployeeInitialsTypeController@update')->name('EmployeeInitials Type Update');
	Route::get('/type/delete/{id}', 'EmployeeInitialsTypeController@destroy')->name('EmployeeInitials Type Delete');
	Route::post('/type/bulkupdate', 'EmployeeInitialsTypeController@bulkUpdate')->name('EmployeeInitials Type Bulk Update');
});
