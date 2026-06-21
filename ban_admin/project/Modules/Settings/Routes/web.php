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

Route::prefix('settings')->group(function() {
	Route::get('/general', 'SettingsController@general')->middleware('role');
	Route::post('/general/update', 'SettingsController@generalUpdate')->middleware('role');
	Route::get('/meta', 'SettingsController@meta')->middleware('role');
	Route::post('/meta/update', 'SettingsController@metaUpdate')->middleware('role');
	Route::get('/social', 'SettingsController@social')->middleware('role');
	Route::post('/social/update', 'SettingsController@socialUpdate')->middleware('role');
	Route::post('/showtopnews/update', 'SettingsController@showTopNewsUpdate');
	Route::post('/showselectednews/update', 'SettingsController@sshowSelectedNewsUpdate');
	Route::post('/showlive/update', 'SettingsController@liveDisplayUpdate');

	Route::get('/page', 'SettingsPageController@index')->name('Settings Page');
	Route::post('/page/store', 'SettingsPageController@store')->name('Settings Page Store');
	Route::post('/page/update', 'SettingsPageController@update')->name('Settings Page Update');
	Route::get('/page/delete/{id}', 'SettingsPageController@destroy')->name('Settings Page Delete');
	Route::post('/page/bulkupdate', 'SettingsPageController@bulkUpdate')->name('Settings Page Bulk Update');
});
