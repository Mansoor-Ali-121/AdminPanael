<?php

namespace App\Helpers;

use App\Models\Sitemap;
use App\Models\AlternatePageModel;

class SitemapHelper
{
    /**
     * Get page content for a given URL
     */
    public static function getpagecontentforthisurl($url)
    {
        return SiteMap::where('url', $url)->value('pagecontent');
    }

    /**
     * Get SEO Meta for a given URL
     */
    public static function getSEOMeta($url)
    {
        // Normalize the URL (remove trailing slashes, etc.)
        $url = trim($url, '/');

        // Agar blank hai to homepage ka alternate URL set karo taake sitemap mein query ho sake
        if ($url === '') {
            // Agar sitemap mein homepage '/' ke bajaye 'homepage' stored hai, toh usko yahan set karo
            $url = 'homepage';  // Ya tumhara jo bhi sitemap mein homepage URL hai
        }

        $alternateModel = app(SiteMap::class);

        // English blog
        if (str_starts_with($url, 'en/blogs/')) {
            $slug = str_replace('en/blogs/', '', $url);
            $article = $alternateModel->getArticleBySlug($slug);

            if ($article) {
                return [
                    'meta_title' => $article->metaTitle,
                    'meta_description' => $article->metaDescription,
                    'canonical' => $article->canonical,
                    'schema' => $article->schema
                ];
            }
        }

        // German blog (not starting with 'en/blogs/')
        if (str_starts_with($url, 'blogs/')) {
            $slug = str_replace('blogs/', '', $url);
            $article = $alternateModel->getGermanArticleBySlug($slug);

            if ($article) {
                return [
                    'meta_title' => $article->metaTitle,
                    'meta_description' => $article->metaDescription,
                    'canonical' => $article->canonical,
                    'schema' => $article->schema
                ];
            }
        }

        // Fallback from sitemap table
        $seoMeta = Sitemap::where('url', $url)
            ->select('meta_title', 'meta_description', 'canonical', 'schema')
            ->first();

        return $seoMeta ? [
            'meta_title' => $seoMeta->meta_title,
            'meta_description' => $seoMeta->meta_description,
            'canonical' => $seoMeta->canonical,
            'schema' => $seoMeta->schema

        ] : null;
    }



    /**
     * Get Canonical URL by given path
     */
    public static function getCanonicalByUrl2($url)
    {
        $alternateModel = app(AlternatePageModel::class);

        if (method_exists($alternateModel, 'getCanonicalByUrl')) {
            return $alternateModel->getCanonicalByUrl($url);
        }

        return null;
    }

    /**
     * Get alternate pages for multilingual support
     */
    public static function getAlternatePages($url)
    {
        $alternateModel = app(AlternatePageModel::class);

        if (method_exists($alternateModel, 'getAlternatePages')) {
            return $alternateModel->getAlternatePages($url);
        }

        return null;
    }

    /**
     * Get Schema markup for SEO
     */
    public static function getSchemaMarkup($url)
    {
        $alternateModel = app(AlternatePageModel::class);

        if (method_exists($alternateModel, 'getSchemaMarkup')) {
            return $alternateModel->getSchemaMarkup($url);
        }

        return null;
    }

    public static function getContentByUrl($url)
    {
        $url = trim($url, '/');
        if ($url === '') {
            $url = 'homepage';
        }

        // Sitemap data get karo
        $sitemapItems = SiteMap::get_sitemap();

        foreach ($sitemapItems as $item) {
            if (trim($item['url'], '/') == $url) {
                return $item['pagecontent'] ?? null;
            }
        }

        // Agar nahi mila to null return karo
        return null;
    }
}
