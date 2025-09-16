<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    @foreach ($data as $url)
        @php
            $loc = $url['url'] === 'homepage' ? url('/') : url($url['url']);
        @endphp

        @if (Str::contains($url['url'], 'zuericlean.com'))
            {{-- agar url already domain name se shuru ho raha hai to kuch na karo --}}
        @else
            <url>
                <loc>{{ $loc }}</loc>
                <changefreq>always</changefreq>
                <priority>{{ $url['priority'] }}</priority>
            </url>
        @endif
    @endforeach

</urlset>
