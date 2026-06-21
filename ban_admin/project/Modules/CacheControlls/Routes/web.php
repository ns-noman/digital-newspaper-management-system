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

Route::prefix('cachecontrolls')->group(function() {
    Route::get('/', 'CacheControllsController@index');
    Route::get('/redis/flush', 'CacheControllsController@redisFlush');
    Route::get('/redis/cachecheck', 'CacheControllsController@redisCacheCheck');
    Route::get('/redis/get/newsView', 'CacheControllsController@getNewsViewRedis');
    ## ajax routes ##
    Route::get('/newsCacheClear',
        'CacheControllsController@newsCacheClear')->name('newsCacheClear');
});
