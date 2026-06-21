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

Route::prefix('electionresults')->group(function() {
    Route::get('/elections', 'ElectionsController@index')->name('Elections');
    Route::post('/elections/store', 'ElectionsController@store')->name('Elections Store');
    Route::post('/elections/update', 'ElectionsController@update')->name('Elections Update');
    Route::get('/elections/delete/{id}', 'ElectionsController@destroy')->name('Elections Delete');
    Route::post('/elections/bulkupdate', 'ElectionsController@bulkUpdate')->name('Elections Bulk Update');

    Route::get('/elections/figures/{election_id}', 'ElectionsFiguresController@index')->name('Elections Figures');
    Route::post('/elections/figures/store', 'ElectionsFiguresController@store')->name('Elections Figures Store');
    Route::post('/elections/figures/update', 'ElectionsFiguresController@update')->name('Elections Figures Update');
    Route::get('/elections/figures/delete/{id}', 'ElectionsFiguresController@destroy')->name('Elections Figures Delete');
    Route::post('/elections/figures/bulkupdate', 'ElectionsFiguresController@bulkUpdate')->name('Elections Figures Bulk Update');

     Route::get('/elections/result/{election_id}', 'ElectionsResultsController@index')->name('Elections Results');
    Route::post('/elections/result/update', 'ElectionsResultsController@update')->name('Elections Results Update');
});
