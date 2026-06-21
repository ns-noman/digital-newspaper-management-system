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

Route::prefix('importantlinkcategories')->group(function() {
    Route::get('/', 'ImportantLinkCategoriesController@index')->name('ImportantLinkCategories');
	Route::post('/store', 'ImportantLinkCategoriesController@store')->name('ImportantLinkCategories Store');
	Route::post('/update', 'ImportantLinkCategoriesController@update')->name('ImportantLinkCategories Update');
	Route::get('/delete/{id}', 'ImportantLinkCategoriesController@destroy')->name('ImportantLinkCategories Delete');
	Route::post('/bulkupdate', 'ImportantLinkCategoriesController@bulkUpdate')->name('ImportantLinkCategories Bulk Update');
});
