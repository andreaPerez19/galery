<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- metas -->
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

        <!-- estilos -->
        <style>
            .nav-link-login:hover {
                background:#fff;
                color:#000 !important;
            }

            @media (max-width: 768px){
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
            @media (min-width: 768px) and (max-width: 900px){
                .content-log{
                    min-width: 465px;
                }
                .content-login{
                    left: 18% !important;
                }
            }

            @media (min-width: 901px) and (max-width: 1169px){
                .content-log{
                    min-width: 465px;
                }
            }
        </style>
        <!-- fin estilos -->
    </head>
    <!--cuerpo login y registro -->
    <body style="background-image: url('/img/gal-l.jpeg'); background-size:cover;">
        <!-- menus login y registro -->
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-transparent shadow-sm">
                <div class="container">
                    <!-- menu en dispositivos moviles -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon bg-white"></span>
                    </button>
                    <!-- fin menu moviles -->

                    <!-- Menu pc -->
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
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
                            <!-- fin authentication links -->
                        </ul>
                    </div>
                    <!-- fin menu pc -->
                </div>
            </nav>
        </div>
        <!-- fin menus -->
        
        <!-- contenido de la vista -->
        <div class="row">
            <div class="col-md-5 content-login" style="position:absolute; left:30%; top:25%;">
                @yield('content')
            </div>
        </div>
        <!-- fin contenido -->
    </body>
    <!--fin cuerpo -->
</html>
