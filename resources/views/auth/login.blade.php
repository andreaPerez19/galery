@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center content-log">
        <div class="col-md-12">
            <h3 class="text-white text-center bg-black mb-0"><b>LOGIN</b></h3>
        </div>
        <div class="col-md-12">
            <div class="card" style="border: none; box-shadow: 0 0 10px #fff;">
                <!-- logo -->
                <div class="card-header" style="background: #19565b; color: #fff; text-align: center;">
                    <img src="/img/logo1.png" alt="logo" style="height:85px;"/>
                </div>
                <!-- fin logo -->
                <div class="card-body">
                    <!-- inicio formulario -->
                    <form id="loginForm">
                        <!-- input correo -->
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Correo electrónico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- input clave -->
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- boton de envio -->
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary" style="background: #19565b; border:none;">
                                    Iniciar sesión
                                </button>
                            </div>
                        </div>
                        <!-- mensajes de error -->
                        <div class="error-message" id="error-message"></div>
                    </form>
                    <!-- fin formulario -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- consumo del backend -->
<script src="{{ asset('js/login.js') }}"></script>
@endsection
