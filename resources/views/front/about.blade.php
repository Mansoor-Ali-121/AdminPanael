@extends('front.index')
@section('content')


    @if(!empty($sitemapContent))
        {!! $sitemapContent !!}
    @else
        <p>This is static/default content</p>
    @endif


@endsection