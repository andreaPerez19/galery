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