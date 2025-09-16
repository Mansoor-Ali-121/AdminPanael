<?php
namespace App\Http\Controllers;

use App\Models\SiteMap;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    // Common logic (if needed)

   public function index()
{
    // Agar request URI blank ho to 'homepage' set kar do
    $url = request()->path() == '/' ? 'homepage' : request()->path();
    $siteMapContent = \App\Helpers\SitemapHelper::getpagecontentforthisurl($url);
    return view('front.index', compact('siteMapContent'));
}

    public function about()
    {
        return view('front.about');
    }

public function sitemapXml()
{
    // Model ka data get karo (assuming model ka naam SiteMap hai)
    $data = SiteMap::get_sitemap();

    // URLs ko normalize karo
    $normalizedData = array_map(function ($item) {
        // URL extract karo (assume karo $item ek associative array hai jisme 'url' key hai)
        $url = isset($item['url']) ? trim($item['url'], '/') : '';

        // Agar URL blank hai to usko 'homepage' set karo
        if ($url === '') {
            $url = 'homepage';
        }

        // Wapas updated URL ke saath data return karo
        $item['url'] = $url;
        return $item;
    }, $data);

    // Debug karna ho to:
    Log::debug(print_r($normalizedData, true));

    // XML response headers set karo aur view return karo
    return response()
        ->view('dashboard.Sitemap.sitemap-xml', ['data' => $normalizedData, 'page' => 'sitemap'])
        ->header('Content-Type', 'text/xml;charset=iso-8859-1');
}

}
