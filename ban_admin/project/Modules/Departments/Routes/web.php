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

Route::prefix('departments')->group(function() {
    Route::get('/', 'DepartmentsController@index')->name('Departments');
	Route::post('/store', 'DepartmentsController@store')->name('Departments Store');
	Route::post('/update', 'DepartmentsController@update')->name('Departments Update');
	Route::get('/delete/{id}', 'DepartmentsController@destroy')->name('Departments Delete');
	Route::post('/bulkupdate', 'DepartmentsController@bulkUpdate')->name('Departments Bulk Update');
});
