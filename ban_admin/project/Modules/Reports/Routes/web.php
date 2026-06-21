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

Route::prefix('reports')->group(function() {
    Route::get('/upload-ga-data', 'ReportsController@uploadGAData')->name('Upload GAData');
    Route::post('/upload-ga-data', 'ReportsController@uploadGADataStore')->name('Upload GAData Store');
    Route::get('/ga-report', 'ReportsController@gaReport')->name('GA Report');
    Route::get('/mis-report', 'ReportsController@misReport')->name('Mis Report');
    Route::get('/subeditor-report', 'ReportsController@subeditorReport')->name('Subeditor Report');
    Route::get('/mp-report', 'ReportsController@mpReport')->name('MP Report');
    Route::get('/mc-report', 'ReportsController@mcReport')->name('MC Report');
    Route::get('/pr-report/news', 'ReportsController@prNewsReport')->name('PR Report News');
    Route::get('/post-report', 'ReportsController@postReport')->name('Post Report');
});
