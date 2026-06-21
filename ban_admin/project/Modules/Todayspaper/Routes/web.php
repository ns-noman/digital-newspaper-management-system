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

Route::prefix('todayspaper')->group(function() {
    Route::get('/', 'TodayspaperController@index')->name('Todayspaper');
    Route::get('/unpublished', 'TodayspaperController@unpublishedList')->name('Todayspaper Unpublished List');
    Route::get('/create', 'TodayspaperController@create')->name('Todayspaper Create');
    Route::post('/store', 'TodayspaperController@store')->name('Todayspaper Store');
    Route::post('/bulkupdate', 'TodayspaperController@bulkUpdate')->name('Todayspaper Bulk Update');
    Route::get('/bulk/create', 'TodayspaperController@bulkCreate')->name('Todayspaper Bulk Create');
    Route::post('/bulk/store', 'TodayspaperController@bulkStore')->name('Todayspaper Bulk Store');
});
