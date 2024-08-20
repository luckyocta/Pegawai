<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-2">
                <li class="nav-item mx-2">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                @auth
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="{{ route('pegawai.data') }}">Data Pegawai</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                    </li>
                @else
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="{{ route('registration') }}">Registration</a>
                    </li>
                @endauth

            </ul>
            <span class="navbar-text ms-auto me-3"{text-align: left;}>
                @auth
                    {{ auth()->user()->name }}
                @endauth
            </span>
        </div>
    </div>
</nav>
