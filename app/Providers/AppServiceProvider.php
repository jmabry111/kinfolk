<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Force a fresh DB connection when running console commands (e.g. scheduler)
        // to prevent "MySQL server has gone away" from Railway's idle connection timeout.
        if ($this->app->runningInConsole()) {
            DB::reconnect();
        }
    }
}
