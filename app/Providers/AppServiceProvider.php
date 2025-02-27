<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // This can be used in blade views to check if the authenticated user is an 'owner'
        Blade::if('isOwner', function () {
            return auth()->user() && (auth()->user()->role === 'owner');
        });

        // This can be used in blade views to check if the authenticated user is a 'user'
        Blade::if('isUser', function () {
            return auth()->user() && (auth()->user()->role === 'user');
        });
    }
}
