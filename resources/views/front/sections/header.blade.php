<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO Meta --}}
    @php
        $currentUrl = url()->current();
        $relativePath = trim(str_replace(url('/'), '', $currentUrl), '/');
        $relativePath = $relativePath ?: '/'; // If empty, treat as home

        $seoMeta = \App\Helpers\SitemapHelper::getSEOMeta($relativePath);

        $page_title = $seoMeta['meta_title'] ?? 'Default Page Title';
        $page_description = $seoMeta['meta_description'] ?? 'Default Page Description';
        $canonical = $seoMeta['canonical'] ?? null;
        $schema = $seoMeta['schema'] ?? null;
        // @dd($schema);

        $alternate = \App\Helpers\SitemapHelper::getAlternatePages($relativePath);
    @endphp



    <title>{{ $page_title }}</title>
    <meta name="description" content="{{ $page_description }}">
    <link rel="canonical" href="{{ $canonical }}"> {{-- fix here --}}

    <link rel="icon" type="image/webp" href="{{ asset('assets/images/logo.webp') }}">
    <link rel="manifest" href="{{ asset('assets/img/favicon/site.webmanifest') }}">

    {{-- Bootstrap, Fonts, Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton+SC&family=Bilbo+Swash+Caps&family=Gruppo&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Swiper, Select2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- App Global CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">

    {{-- Per Page Styles --}}
    @stack('styles')

    {{-- Alertify --}}
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Alternate Language URLs --}}
    @if (!empty($alternate))
        @foreach ($alternate as $alt)
            <link rel="alternate" hreflang="{{ $alt['hreflang'] }}" href="{{ $alt['href'] }}" />
        @endforeach
    @endif

    @if (!empty($schema) && str_contains($schema, '<script type="application/ld+json">'))
    {!! $schema !!}
@endif


</head>


