<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/adminstyle.css') }}">
    <script src="{{ asset('dashboard/assets/js/admin/sidebar.js') }}"></script>
    {{-- <script src="{{ asset('dashboard/assets/js/admin/scheduling.js') }}"></script> --}}

    @yield('local-styles')

    {{-- TinyMCE --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tinymce@8.0.2/skins/ui/oxide/content.min.css">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @yield('local-scripts')

    @php
        use Illuminate\Support\Facades\URL;
        use App\Helpers\SitemapHelper;

        // Base URL without trailing slash
        $baseUrl = rtrim(URL::to('/'), '/');

        // Current URL
        $currentUrl = URL::current();

        // Relative path = current URL minus base URL
        $relativePath = ltrim(str_replace($baseUrl, '', $currentUrl), '/');

        // Call your helper functions (jo tumne Laravel helper me banaye hain)
        // $canonical = SitemapHelper::getCanonicalByUrl2($relativePath);
        // $alternatePages = getAlternatePages($relativePath);
        // $schema = getSchemaMarkup($relativePath);

        // SEO Meta data for title and description
        // $seoMeta = getSEOMeta($relativePath);
        // if (!empty($seoMeta)) {
        //     $pageTitle = $seoMeta['meta_title'];
        //     $pageDescription = $seoMeta['meta_description'];
        // } else {
        //     $pageTitle = $pageTitle ?? 'Default Page Title';
        //     $pageDescription = $pageDescription ?? 'Default Page Description';
        // }
        // @dd($canonical);
    @endphp


{{-- Seo  --}}
    {{-- <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">

    @if (!empty($canonical['canonical']))
        <link rel="canonical" href="{{ e($canonical['canonical']) }}" />
    @else
        <link rel="canonical" href="{{ e(url($relativePath)) }}" />
    @endif

    @if (!empty($alternatePages))
        @foreach ($alternatePages as $alternate)
            <link rel="alternate" hreflang="{{ e($alternate['hreflang']) }}" href="{{ e($alternate['href']) }}" />
        @endforeach
    @endif

    @if (!empty($schema))
        {!! $schema !!}
    @endif --}}

</head>


<body>
