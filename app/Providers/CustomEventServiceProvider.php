<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class CustomEventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public static function shouldBooted()
    {
        /** FORMAT :
        Object::event(function ($model) {
            // do something with $model instances
        });
        **/
        setlocale(LC_TIME, config('app.locale'));
        Carbon::setLocale(config('app.fallback_locale'));
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
