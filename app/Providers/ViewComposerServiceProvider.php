<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Helpers\SitemapHelper;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Sab front views me $sitemapContent variable bhejo
        View::composer('front.*', function ($view) {
            $url = request()->path();
            $sitemapContent = SitemapHelper::getContentByUrl($url);
            // dd($sitemapContent);
            $view->with('sitemapContent', $sitemapContent);
        });
    }

    public function register()
    {
        //
    }
}
