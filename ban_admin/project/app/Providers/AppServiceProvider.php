<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Auth;
use View;
use DB;

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

        // \DB::connection()->enableQueryLog();
        // \Event::listen('kernel.handled', function ($request, $response) {
        //     if ( $request->has('q') ) {
        //         $queries = \DB::getQueryLog();
        //         dd($queries);
        //     }
        // });

        view()->composer('layouts.app', function ($view) {
            $view->with('userInfoLogged', \Modules\Users\Http\Controllers\UsersController::loggedinUserInfo());
        });

        $settingsInfo = \Modules\Settings\Http\Controllers\SettingsController::settingsInfo();
        View::share('settingsInfo', $settingsInfo);
        $_ENV['topnews'] = !empty($settingsInfo->show_topnews) ? $settingsInfo->show_topnews : 7;
    }
}
