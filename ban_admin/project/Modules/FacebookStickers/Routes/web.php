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

Route::prefix('facebookstickers')->group(function() {
    Route::get('/', 'FacebookStickersController@index')->name('FacebookStickers');
    Route::post('/store', 'FacebookStickersController@store')->name('FacebookStickers Store');
    Route::post('/update', 'FacebookStickersController@update')->name('FacebookStickers Update');
    Route::get('/delete/{id}', 'FacebookStickersController@destroy')->name('FacebookStickers Delete');
    Route::post('/bulkupdate', 'FacebookStickersController@bulkUpdate')->name('FacebookStickers Bulk Update');
});
