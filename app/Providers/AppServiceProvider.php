<?php

namespace App\Providers;

use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Helpers\SitemapHelper;
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

        // Har view mein current URL ka content share karo
        View::composer('*', function ($view) {
            $currentUrl = request()->path(); // current URL without domain and query
            $content = SitemapHelper::getContentByUrl($currentUrl);

            $view->with('sitemapContent', $content);
        });
    }
}
