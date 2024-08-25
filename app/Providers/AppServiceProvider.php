<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('EcomApi', \App\Services\Api\EcomApiServices::class);
        $this->app->bind('AnalyzeApi', \App\Services\Api\AnalyzeApiServices::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
