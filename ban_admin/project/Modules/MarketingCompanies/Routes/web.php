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

Route::prefix('marketingcompanies')->group(function() {
    Route::get('/', 'MarketingCompaniesController@index')->name('MarketingCompanies');
	Route::post('/store', 'MarketingCompaniesController@store')->name('MarketingCompanies Store');
	Route::post('/update', 'MarketingCompaniesController@update')->name('MarketingCompanies Update');
	Route::get('/delete/{id}', 'MarketingCompaniesController@destroy')->name('MarketingCompanies Delete');
	Route::post('/bulkupdate', 'MarketingCompaniesController@bulkUpdate')->name('MarketingCompanies Bulk Update');
});
