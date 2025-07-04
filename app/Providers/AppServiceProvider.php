<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\UsersEvent;
use App\Listeners\UpdateUserLocationInDB;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(UsersEvent::class, UpdateUserLocationInDB::class);
    }
}
