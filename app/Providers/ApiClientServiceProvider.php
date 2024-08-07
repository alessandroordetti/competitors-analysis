<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ApiClient;

class ApiClientServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ApiClient::class, function ($app) {
            return new ApiClient('https://api.example.com');
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
