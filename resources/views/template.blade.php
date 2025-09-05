@include('dashboard.includes.header')
@include('dashboard.includes.menu')

<!-- Layout Wrapper -->
<div class="main-dashboard-content">
    @include('dashboard.includes.sidebar')

    <div class="main_content">
        <div class="container">
            @yield('dashboard-content')
        </div>
    </div>
</div>
@include('dashboard.includes.footer')
