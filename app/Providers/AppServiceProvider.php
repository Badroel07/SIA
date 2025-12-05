<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // Import Facade URL
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\Paginator;

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
        // Solusi untuk Mixed Content Error di Vercel/Proxy
        if (env('APP_ENV') !== 'local' && config('app.env') !== 'local') {
            // Secara eksplisit memaksa skema URL ke HTTPS di semua link asset
            // (Termasuk yang dibuat oleh @vite)
            URL::forceScheme('https');
        }

        Paginator::useTailwind();

        // Anda juga bisa mencoba ini, terutama jika Anda menggunakan Load Balancer/Proxy
        /*
        if ($this->app->environment('production', 'staging')) {
            \URL::forceScheme('https');
        }
        */
    }
}
