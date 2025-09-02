<nav class="navbar navbar-expand-lg mynavbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}"><img id="logo" src="{{ asset('dashboard/assets/images/logo.webp') }}"
                alt="App Coding Tech"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link mybtninadmin" href="{{ url('admin') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('admin/users') }}">Users</a>
                </li>

                <li class="nav-item">

                    @if (!session('admin'))
                        <a class="nav-link" href="{{ url('admin/login') }}">
                            <div style="color:yellow;">Login</div>
                        </a>
                    @else
                        <a class="nav-link" href="{{ url('admin/logout') }}">
                            <div style="color:red;">Logout</div>
                        </a>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</nav>
