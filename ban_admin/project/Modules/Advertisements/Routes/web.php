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

Route::prefix('advertisements')->group(function() {
    Route::get('/placements', 'AdvertisementsPlacementsController@index')->name('Advertisements Placements');
    Route::post('/placements/store', 'AdvertisementsPlacementsController@store')->name('Advertisements Placements Store');
    Route::post('/placements/update', 'AdvertisementsPlacementsController@update')->name('Advertisements Placements Update');
    Route::get('/placements/delete/{id}', 'AdvertisementsPlacementsController@destroy')->name('Advertisements Placements Delete');
    Route::post('/placements/bulkupdate', 'AdvertisementsPlacementsController@bulkUpdate')->name('Advertisements Placements Bulk Update');

    Route::get('/placements/orders/{placementId}', 'AdvertisementsOrdersController@index')->name('Advertisements Orders');
    Route::post('/placements/orders/store', 'AdvertisementsOrdersController@store')->name('Advertisements Orders Store');
    Route::post('/placements/orders/update', 'AdvertisementsOrdersController@update')->name('Advertisements Orders Update');
    Route::get('/placements/orders/detail/{id}', 'AdvertisementsOrdersController@orderDetail')->name('Advertisements Orders Detail');
});
