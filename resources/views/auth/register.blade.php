@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center content-log">
        <div class="col-md-12">
            <h3 class="text-white text-center bg-black mb-0"><b>REGISTRO</b></h3>
        </div>
        <div class="col-md-12">
            <div class="card">
                <!-- logo -->
                <div class="card-header" style="background: #19565b; color: #fff; text-align: center;">
                    <img src="/img/logo1.png" alt="logo" style="height:85px;"/>
                </div>
                <!-- fin logo -->
                <div class="card-body">
                    <!-- inicio formulario -->
                    <form method="POST" action="{{ route('registerjwt') }}">
                        @csrf
                        <!-- input nombre -->
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nombre</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- input correo -->
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Correo electrónico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- input confirmacion clave -->
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirmar contraseña</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <!-- boton de envio -->
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" style="background: #19565b; border:none;">
                                    Registrar
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- fin formulario -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
