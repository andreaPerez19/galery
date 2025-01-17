<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        .nav-link-login:hover {
            background:#fff;
            color:#000 !important;
        }

        @media (max-width: 500px){
            .content-login{
                left: 0 !important;
            }

            .nav-link-login {
                background:#fff;
                color:#000 !important;
                text-align: center;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body style="background-image: url('/img/gal-l.jpeg'); background-size:cover;">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-transparent shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon bg-white"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link nav-link-login text-white me-3" style="border: 1px solid; border-radius: 30px;" href="{{ route('login') }}">Login</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link nav-link-login text-white" style="border: 1px solid; border-radius: 30px;" href="{{ route('register') }}">Registro</a>
                            </li>
                        @endif                        
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="row">
        <!-- Right Side Start -->
        <div class="col-md-5 content-login" style="position:absolute; left:30%; top:25%;">
            @yield('content_right')
        </div>
        <!-- Right Side End -->
    </div>
</body>
</html>
