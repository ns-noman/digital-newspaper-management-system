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

Route::prefix('tools')->group(function() {
    Route::get('/cards', 'ToolsController@cards')->name('Card');
    Route::get('/commentcard/ajax/generate', 'ToolsController@ajaxGenerateCommentCard');
    Route::get('/namazcard/ajax/generate', 'ToolsController@ajaxGenerateNamazCard');

    Route::get('/photocard/generate/{newsId}', 'ToolsController@ajaxGeneratePhotoCard')->name('PhotoCard Generate');
    Route::get('/pollcard/ajax/generate/{id}', 'ToolsController@ajaxGeneratePollCard');
});
