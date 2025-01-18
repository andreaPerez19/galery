const token = localStorage.getItem('jwt_token'); // Obtener el token desde el localStorage

if (!token) {
    // Si no hay token, redirigir al login
    window.location.href = 'http://'+location.host+'/login';
}

// Función para obtener los detalles del usuario desde la API
async function getUserDetails() {
    try {
        const response = await fetch('http://'+location.host+'/api/users', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,  // Incluir el token en la cabecera
                'Content-Type': 'application/json',
            }
        });

        const data = await response.json();
        
        if (response.ok) {
            // Mostrar usuario autenticado
            document.getElementById('user-info').innerHTML = `
                <div>${data.name}</div>
                <div>${data.email}</div>
            `;
        } else {
            // Si la respuesta no es ok, mostrar el mensaje de error
            document.getElementById('error-message').innerText = data.message || 'Error al obtener los detalles del usuario';
        }
    } catch (error) {
        // Si hay un error en la solicitud
        console.error('Error:', error);
    }
}

// Función para cerrar sesión (eliminar el token)
function logoutUser() {
    localStorage.removeItem('jwt_token'); // Eliminar el token del localStorage
    window.location.href = 'http://'+location.host+'/login'; // Redirigir al login
}

// Llamar a la función para cargar los detalles del usuario al cargar la página
getUserDetails();