<?php

namespace App\Providers;

use App\SuitEvent\Models\EmailSetting;
use App\SuitEvent\Notifications\Contracts\EmailSettingInterface as EmailSettingContract;
use App\SuitEvent\Repositories\NotificationRepository;
use Illuminate\Support\ServiceProvider;
use Suitcore\Emailer\Emailer;
use Suitcore\FileGrabber\FileGrabber;
use Suitcore\Thumbnailer\Thumbnailer;
use Suitcore\Uploader\Upload;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Start Custom Service Provider
        CustomEventServiceProvider::shouldBooted();

        // Other Actions
        // Emailer
        $emailer = $this->app['emailer'];
        $emailer->compose(config('suitevent.emailer', []));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('upload', function () {
            return new Upload;
        });

        $this->app->singleton('thumbnailer', function () {
            return new Thumbnailer;
        });

        $this->app->singleton('emailer', function ($app) {
            $mailer = $this->app['mailer'];
            $emailer = new Emailer($mailer);
            $emailSetting = new EmailSetting;
            $emailer->setEmailSetting($emailSetting);
            return $emailer;
        });

        $this->app->singleton('filegrab', function ($app) {
            $grabber = new FileGrabber;
            $grabber->setTemp(storage_path('app/grabbers'), 0775);
            return $grabber;
        });

        $this->app->alias(EmailSetting::class, EmailSettingContract::class);

        // rollbar only for production
        if ($this->app->environment('production') || $this->app->environment('staging')) {
            $this->app->register(\Jenssegers\Rollbar\RollbarServiceProvider::class);
        }
    }
}
