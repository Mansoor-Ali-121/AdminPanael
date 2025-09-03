@section('local-scripts-home')
    <script src="{{ asset('dashboard/assets/js/admin/home.js') }}"></script>
@endsection

@section('local-scripts-addBlog')
    <script src="{{ asset('dashboard/assets/js/admin/scheduling.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/admin/functions.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/admin/tinymceload.js') }}"></script>
@endsection

@section('local-scripts-editBlog')
    @yield('local-scripts-addBlog')
@endsection

@section('local-scripts-sitemap-editUrl')
    <script src="{{ asset('dashboard/assets/js/admin/tinymceload.js') }}"></script>
@endsection

@section('local-scripts-editBlog')
    @yield('local-scripts-sitemap-addUrl')
@endsection
