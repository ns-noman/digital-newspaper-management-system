<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Frontend Controllers
|--------------------------------------------------------------------------
|
*/
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\AboutUsFEController;
use App\Http\Controllers\frontend\CustomerFEController;
use App\Http\Controllers\frontend\FacebookController;
use App\Http\Controllers\frontend\GoogleController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\WishListController;
use App\Http\Controllers\frontend\OrderFEController;
use App\Http\Controllers\frontend\ReviewFEController;
use App\Http\Controllers\frontend\blogFEController;
// use App\Http\Controllers\frontend\UserFEController;




Route::get('/clear', function() {   
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return 'View cache has been cleared';
});

Route::get('backend',function(){return redirect()->route('admin.login');});
Route::get('admin',function(){return redirect()->route('admin.login');});
Route::get('login',function(){return redirect()->route('admin.login');});

Route::prefix('admin')->group(function () {
    route::namespace('App\Http\Controllers\admin')->group(function(){
        Route::prefix('login')->controller(AdminController::class)->group(function(){
            Route::match(['get', 'post'],'', 'login')->name('admin.login');
        });
        Route::middleware('admin')->group(function (){
            Route::prefix('menus')->controller(MenuController::class)->group(function(){
                Route::get('','index')->name('menus.index');
                Route::get('create','createOrEdit')->name('menus.create');
                Route::get('edit/{id?}/{addmenu?}','createOrEdit')->name('menus.edit');
                Route::post('store','store')->name('menus.store'); 
                Route::put('update/{id}','update')->name('menus.update');
                Route::delete('delete/{id}','destroy')->name('menus.destroy');
            });
            Route::prefix('logout')->controller(AdminController::class)->group(function(){
                Route::post('', 'logout')->name('admin.logout');
            });
            Route::prefix('dashboard')->controller(DashboardController::class)->group(function(){
                Route::get('','index')->name('dashboard.index');
            });
            Route::prefix('basic-infos')->controller(BasicInfoController::class)->group(function(){
                Route::get('','index')->name('basic-infos.index');
                Route::put('update/{id}','update')->name('basic-infos.update');
                Route::get('edit/{id?}','edit')->name('basic-infos.edit');
            });
            Route::prefix('admin')->group(function(){
                Route::prefix('roles')->controller(RoleController::class)->group(function(){
                    Route::get('','index')->name('roles.index');
                    Route::get('create','createOrEdit')->name('roles.create');
                    Route::get('edit/{id?}','createOrEdit')->name('roles.edit');
                    Route::post('store','store')->name('roles.store');
                    Route::put('update/{id}','update')->name('roles.update');
                    Route::delete('delete/{id}','destroy')->name('roles.destroy');
                });
                Route::prefix('admins')->controller(AdminController::class)->group(function(){
                    Route::get('','index')->name('admins.index');
                    Route::get('create','createOrEdit')->name('admins.create');
                    Route::get('edit/{id?}','createOrEdit')->name('admins.edit');
                    Route::post('store','store')->name('admins.store');
                    Route::put('update/{id}','update')->name('admins.update');
                    Route::delete('delete/{id}','destroy')->name('admins.destroy');
                });
            });

            Route::prefix('password')->controller(AdminController::class)->group(function(){
                Route::match(['get', 'post'],'update/{id?}','updatePassword')->name('admin.password.update');
                Route::post('check-password','checkPassword')->name('admin.password.check');
            });
            Route::prefix('profile')->controller(AdminController::class)->group(function(){
                Route::match(['get', 'post'],'update-details/{id?}','updateDetails')->name('profile.update-details');;
            });

            Route::prefix('categories')->controller(CategoryController::class)->group(function(){
                Route::get('','index')->name('categories.index');
                Route::get('create','createOrEdit')->name('categories.create');
                Route::get('edit/{id?}','createOrEdit')->name('categories.edit');
                Route::post('store','store')->name('categories.store');
                Route::put('update/{id}','update')->name('categories.update');
                Route::delete('delete/{id}','destroy')->name('categories.destroy');
            });
            Route::prefix('tags')->controller(TagController::class)->group(function(){
                Route::get('','index')->name('tags.index');
                Route::get('create','createOrEdit')->name('tags.create');
                Route::get('edit/{id?}','createOrEdit')->name('tags.edit');
                Route::post('store','store')->name('tags.store');
                Route::put('update/{id}','update')->name('tags.update');
                Route::delete('delete/{id}','destroy')->name('tags.destroy');
            });
            Route::prefix('writers')->controller(WriterController::class)->group(function(){
                Route::get('','index')->name('writers.index');
                Route::get('create','createOrEdit')->name('writers.create');
                Route::get('edit/{id?}','createOrEdit')->name('writers.edit');
                Route::post('store','store')->name('writers.store');
                Route::put('update/{id}','update')->name('writers.update');
                Route::delete('delete/{id}','destroy')->name('writers.destroy');
            });
            Route::prefix('reporters')->controller(ReporterController::class)->group(function(){
                Route::get('','index')->name('reporters.index');
                Route::get('create','createOrEdit')->name('reporters.create');
                Route::get('edit/{id?}','createOrEdit')->name('reporters.edit');
                Route::post('store','store')->name('reporters.store');
                Route::put('update/{id}','update')->name('reporters.update');
                Route::delete('delete/{id}','destroy')->name('reporters.destroy');
            });
            Route::prefix('pages')->controller(PageController::class)->group(function(){
                Route::get('','index')->name('pages.index');
                Route::get('create','createOrEdit')->name('pages.create');
                Route::get('edit/{id?}','createOrEdit')->name('pages.edit');
                Route::post('store','store')->name('pages.store');
                Route::put('update/{id}','update')->name('pages.update');
                Route::delete('delete/{id}','destroy')->name('pages.destroy');
            });
            Route::prefix('polls')->controller(PollController::class)->group(function(){
                Route::get('','index')->name('polls.index');
                Route::get('create','createOrEdit')->name('polls.create');
                Route::get('edit/{id?}','createOrEdit')->name('polls.edit');
                Route::post('store','store')->name('polls.store');
                Route::put('update/{id}','update')->name('polls.update');
                Route::delete('delete/{id}','destroy')->name('polls.destroy');
            });
            Route::prefix('galleries')->controller(GalleryController::class)->group(function(){
                Route::get('','index')->name('galleries.index');
                Route::get('create','createOrEdit')->name('galleries.create');
                Route::get('edit/{id?}','createOrEdit')->name('galleries.edit');
                Route::post('store','store')->name('galleries.store');
                Route::put('update/{id}','update')->name('galleries.update');
                Route::delete('delete/{id}','destroy')->name('galleries.destroy');
                Route::get('load-subcategories/{cat_id}','loadSubcategories')->name('galleries.load-subcategories');
            });
            Route::prefix('ads-positions')->controller(AdsPositionController::class)->group(function(){
                Route::get('','index')->name('ads-positions.index');
                Route::get('create','createOrEdit')->name('ads-positions.create');
                Route::get('edit/{id?}','createOrEdit')->name('ads-positions.edit');
                Route::post('store','store')->name('ads-positions.store');
                Route::put('update/{id}','update')->name('ads-positions.update');
                Route::delete('delete/{id}','destroy')->name('ads-positions.destroy');
            });
            Route::prefix('my-ads')->controller(AdsController::class)->group(function(){
                Route::get('','index')->name('my-ads.index');
                Route::get('create','createOrEdit')->name('my-ads.create');
                Route::get('edit/{id?}','createOrEdit')->name('my-ads.edit');
                Route::post('store','store')->name('my-ads.store');
                Route::put('update/{id}','update')->name('my-ads.update');
                Route::delete('delete/{id}','destroy')->name('my-ads.destroy');
            });
            Route::prefix('news')->controller(NewsController::class)->group(function(){
                Route::get('','index')->name('news.index');
                Route::get('create','createOrEdit')->name('news.create');
                Route::get('edit/{id?}','createOrEdit')->name('news.edit');
                Route::post('store','store')->name('news.store');
                Route::put('update/{id}','update')->name('news.update');
                Route::delete('delete/{id}','destroy')->name('news.destroy');
                Route::get('related-news','relatedNews')->name('news.related-news');
            });
        });
    });
});


route::namespace('App\Http\Controllers\frontend')->group(function(){
    Route::get('/','HomeController@index')->name('home.index');
    Route::prefix('weathers')->controller(WeatherController::class)->group(function(){
        Route::get('','index')->name('weathers.index');
    });
    Route::prefix('categories')->controller(CategoryFEController::class)->group(function(){
        Route::get('{link}/{id}','categories')->name('categories.categories');
    });
    Route::prefix('news')->controller(NewsFEController::class)->group(function(){
        Route::get('{slug}','news')->name('news.news');
        Route::get('print/{id}','newsprint')->name('news.print');
        Route::post('comment','comment')->name('news.comment');
        Route::post('visitnum','visitnum')->name('news.visitnum');
    });
    Route::prefix('archives')->controller(ArchiveFEController::class)->group(function(){
        Route::match(['get','post'],'/{date?}','index')->name('archives.index');
    });
    Route::prefix('search')->controller(SearchFEController::class)->group(function(){
        Route::get('/{q?}','index')->name('search.index');
    });
    Route::prefix('fe-pages')->controller(PageFEController::class)->group(function(){
        Route::get('/{slug}','index')->name('fe-pages.index');
    });
    Route::prefix('online-polls')->controller(PollFEController::class)->group(function(){
        Route::post('vote','vote')->name('online-polls.vote');
        Route::get('result','result')->name('online-polls.result');
    });
});


require __DIR__.'/auth.php';
