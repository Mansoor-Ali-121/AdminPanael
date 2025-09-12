<?php

namespace App\Providers;

use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;
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
        // Middleware ko alias name se register kar raha hai
        app('router')->aliasMiddleware('check.admin', CheckAdmin::class);
    }
}
