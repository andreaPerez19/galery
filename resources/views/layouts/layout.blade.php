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
    </head>
    <body>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel11') }} 11
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>
                    <div class="user-info me-3" id="user-info">
                        <!-- Los detalles del usuario se mostrarán aquí -->
                    </div>
                    <button onclick="logoutUser()">Cerrar sesión</button>
                            
                    
                </div>
            </div>
        </nav>
        <div id="root">
            <main>
                <div class="container">
                    <div class="row">
                        <!-- Page Content Start -->
                        <div class="col">
                            <!-- Title and Top Buttons Start -->
                            <div class="page-title-container mb-3">
                                <div class="row">
                                    <!-- Title Start -->
                                    <div class="col mb-2">
                                        <h5 class="mb-2 pb-0 display-4" id="title"></h5>
                                        <div class="text-muted font-heading text-small"></div>
                                    </div>
                                    <!-- Title End -->
                                </div>
                            </div>
                            <!-- Title and Top Buttons End -->


                            @yield('content')

                        </div>

                        <!-- Page Content End -->
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
