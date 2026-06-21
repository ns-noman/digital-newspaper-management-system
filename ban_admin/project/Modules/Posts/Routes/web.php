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

Route::prefix('posts')->group(function() {
	Route::get('/', 'PostsController@index')->name('Posts');
	Route::get('/create', 'PostsController@create')->name('Posts Create');
	Route::post('/store', 'PostsController@store')->name('Posts Store');
	Route::get('/edit/{id}', 'PostsController@edit')->name('Posts Edit');
	Route::post('/update/{id}', 'PostsController@update')->name('Posts Update');
	Route::post('/bulkupdate', 'PostsController@bulkUpdate')->name('Posts Bulk Update');
	Route::get('/photos', 'PostsController@photos')->name('Posts Photos');
	Route::get('/videos', 'PostsController@videos')->name('Posts Videos');
	Route::get('/audios', 'PostsController@audios')->name('Posts Audios');
	Route::get('/draft', 'PostsController@draft')->name('Posts Draft');
	Route::get('/leadtop', 'PostsController@leadtop')->name('Posts LeadTop');
	Route::get('/selected', 'PostsController@selected')->name('Posts Selected');
	Route::get('/my-post', 'PostsController@myPost')->name('Posts MyPost');
	Route::get('/paid-post', 'PostsController@paidPost')->name('Posts PaidPost');
});
