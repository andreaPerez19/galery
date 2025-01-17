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
</head>
    <body>
        <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background: #19565b; color: #fff;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/img/logo1.png" alt="logo" style="height:85px;"/>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent2">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>
                    <img src="/img/acceso.png" alt="icon" style="width:40px; background: #fff; border-radius: 100%; margin-right:10px;"/>

                    <div class="user-info me-3" id="user-info">
                        <!-- Los detalles del usuario se mostrarán aquí -->
                    </div>
                    <button onclick="logoutUser()" class="bg-transparent text-white" style="border: 1px solid #fff; border-radius: 30px;">Cerrar sesión</button>
                            
                    
                </div>
            </div>
        </nav>
        <div id="root">
            <main>
                <div class="container">
                    @yield('content')
                </div>
            </main>
        </div>
    </body>
</html>
