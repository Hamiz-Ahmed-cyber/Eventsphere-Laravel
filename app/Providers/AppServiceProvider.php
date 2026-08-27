<?php

namespace App\Providers;

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
        // Railway (and most PaaS platforms) terminate SSL at their edge proxy
        // and forward requests to the container over plain HTTP. Laravel
        // doesn't know the original request was HTTPS, so it generates
        // asset/CSS/JS links with http:// instead of https:// — causing
        // the browser to block them as "mixed content".
        //
        // Forcing the scheme here makes every url()/asset()/vite() call
        // always use https, regardless of what the internal request looked like.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}