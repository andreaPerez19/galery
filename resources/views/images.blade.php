@extends('layouts.layout')

@section('content')
<div>
    <h3 class="text-center my-3"><b>Galería de imágenes</b></h3>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background: #19565b; border:none;">
        + Agregar imagen
    </button>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 740px;">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar imagen</h5>                
            </div>
            <div class="modal-body">
                <!-- Formulario para subir imágenes -->
                <form id="uploadForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label for="title" class="col-md-4 col-form-label text-md-end">Título</label>

                        <div class="col-md-6">
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="image" class="col-md-4 col-form-label text-md-end">Subir imágen</label>

                        <div class="col-md-6">            
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" required>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="description" class="col-md-4 col-form-label text-md-end">Descripción</label>

                        <div class="col-md-6">            
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" rows="3" name="description" value="{{ old('description') }}" required></textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary me-3" style="background: #19565b; border:none;">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">                                
            </div>
            </div>
        </div>
    </div>

    <ul id="imageList">
        <!-- Las imágenes se cargarán aquí -->
    </ul>

    <div class="error-message" id="error-message"></div>
</div>

<script>
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
                // Mostrar los detalles del usuario
                document.getElementById('user-info').innerHTML = `
                    <div>${data[0].name}</div>
                    <div>${data[0].email}</div>
                `;
            } else {
                // Si la respuesta no es ok, mostrar el mensaje de error
                document.getElementById('error-message').innerText = data.message || 'Error al obtener los detalles del usuario';
            }
        } catch (error) {
            // Si hay un error en la solicitud
            document.getElementById('error-message').innerText = 'Hubo un problema al intentar cargar los datos del usuario. Intenta nuevamente.';
        }
    }

    // Función para cerrar sesión (eliminar el token)
    function logoutUser() {
        localStorage.removeItem('jwt_token'); // Eliminar el token del localStorage
        window.location.href = 'http://'+location.host+'/login'; // Redirigir al login
    }

    // Llamar a la función para cargar los detalles del usuario al cargar la página
    getUserDetails();

    //agregar imagenes
    document.getElementById('uploadForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        
        const formData = new FormData();
        const image = document.getElementById('image').files[0];
        const title = document.getElementById('title').value;
        const description = document.getElementById('description').value;
        formData.append('image', image);        
        
        try {
            const response = await fetch('http://'+location.host+'/api/images', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                },                
                body: JSON.stringify({
                    title: title,
                    description: description,
                    image: image
                })
            });

            console.log(response);

            //const data = await response.json();
            if (response.ok) {
                alert('Imagen subida con éxito');
                loadImages();  // Cargar las imágenes nuevamente
            } 
        } catch (error) {
            console.error('Error:', error);
        }
    });

    async function loadImages() {
        try {
            const response = await fetch('/api/images', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                },
            });

            const images = await response.json();
            console.log(images);
            const imageList = document.getElementById('imageList');
            imageList.innerHTML = '';
            images.forEach(image => {
                const li = document.createElement('li');
                const imageUrl = `/api/images/${image.id}/view`;  // Usamos la nueva ruta para acceder a la imagen
                li.innerHTML = `<img src="${imageUrl}" alt="${image.name}" width="100" height="100">`;
                imageList.appendChild(li);
            });
        } catch (error) {
            // Si hay un error en la solicitud
            document.getElementById('error-message').innerText = 'No hay imagenes para mostrar';
        }
    }

    // Cargar las imágenes cuando la página cargue
    loadImages();
</script>
@endsection
