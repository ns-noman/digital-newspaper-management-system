<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Http\Controllers\CommonController;
use DB;
use View;
use App\Models\Categories;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        $commonController = new CommonController;
        $settingsInfo = $commonController->settingsInfo();
        $pageInfo = $commonController->settingsPageInfo();
        $headerCategories = $commonController->getHeaderCategories();
        View::share('settingsInfo', $settingsInfo);
        View::share('pageInfo', $pageInfo);
        View::share('headerCategories', $headerCategories);
        $_ENV['topnews'] = !empty($settingsInfo->show_topnews) ? $settingsInfo->show_topnews : 7;
        $_ENV['selected2news'] = !empty($settingsInfo->show_selected2) ? $settingsInfo->show_selected2 : Null;
        $_ENV['showlive'] = !empty($settingsInfo->show_live) ? $settingsInfo->show_live : Null;
    }

}
