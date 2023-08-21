<?php

namespace App\Providers;

use App\Models\SmsBannedWord;
use App\Observers\NotificationObserver;
use App\Observers\SmsBannedWordObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Laravel\Nova\Notifications\Notification;

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
        Paginator::useBootstrap();
        Notification::observe(NotificationObserver::class);
        $this->observers();
    }

    private function observers(){
        SmsBannedWord::observe(SmsBannedWordObserver::class);
    }
}
