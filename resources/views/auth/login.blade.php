@extends('layouts.app')

@section('content_right')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3 class="text-white text-center bg-black mb-0"><b>LOGIN</b></h3>
        </div>
        <div class="col-md-12">
            <div class="card" style="border: none; box-shadow: 0 0 10px #fff;">
                <div class="card-header" style="background: #19565b; color: #fff; text-align: center;">
                    <img src="/img/logo1.png" alt="logo" style="height:85px;"/>
                </div>

                <div class="card-body">
                    <form id="loginForm">
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

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary" style="background: #19565b; border:none;">
                                    Iniciar sesión
                                </button>
                            </div>
                        </div>

                        <div class="error-message" id="error-message"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Función para manejar el login
    async function loginUser(event) {
        event.preventDefault();  // Evitar que el formulario se envíe de la forma tradicional

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        var LocationActual = 'http://'+location.host+'/api/login';
        // Verificar que los campos no estén vacíos
        if (!email || !password) {
            document.getElementById('error-message').innerText = 'Por favor, ingrese todos los campos.';
            return;
        }

        try {
            // Enviar la solicitud de login al servidor
            const response = await fetch(LocationActual, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    email: email,
                    password: password
                })
            });

            const data = await response.json();

            if (response.ok) {
                // Si el login es exitoso, almacenar el token JWT en localStorage
                localStorage.setItem('jwt_token', data.token);                
                window.location.href = 'http://'+location.host+'/images'; // Redirigir a una página protegida
            } else {
                // Si hay un error (por ejemplo, credenciales incorrectas)
                document.getElementById('error-message').innerText = data.message || 'Error al iniciar sesión';
            }
        } catch (error) {
            // Si hay un error en la solicitud (por ejemplo, problema de red)
            document.getElementById('error-message').innerText = 'Hubo un problema al intentar iniciar sesión. Intenta nuevamente.';
        }
    }

    // Asignar la función al evento del formulario
    document.getElementById('loginForm').addEventListener('submit', loginUser);
</script>
@endsection
