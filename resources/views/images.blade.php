@extends('layouts.layout')

@section('content')
<div>
    <h3 class="text-center my-3"><b>Galería de imágenes</b></h3>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background: #19565b; border:none;">
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

    <!-- Modal -->
    <!-- Modal Editar Imagen -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 740px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar imagen</h5>                
                </div>
                <div class="modal-body">
                    <!-- Formulario para editar imagen -->
                    <form id="editForm">
                        @csrf
                        <input type="hidden" id="editImageId" name="id">  <!-- Campo oculto para el ID de la imagen -->

                        <div class="row mb-3">
                            <div class="col-md-2"><img id="editImg" width="150" height="150"/></div>
                            <div class="col-md-10">
                                <div class="row">
                                    <label for="editTitle" class="col-md-4 col-form-label text-md-end">Título</label>
                                    <div class="col-md-6">
                                        <input id="editTitle" type="text" class="form-control mb-3" name="title" required>
                                    </div>                        
                                    <label for="editDescription" class="col-md-4 col-form-label text-md-end">Descripción</label>
                                    <div class="col-md-6">
                                        <textarea id="editDescription" class="form-control" name="description" required></textarea>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary me-3" style="background: #19565b; border:none;">Actualizar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 500px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="deleteImageId" name="id">  <!-- Campo oculto para el ID de la imagen -->
                    ¿Estás seguro de que deseas eliminar esta imagen? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Campo de búsqueda -->
    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar imágenes...">

    <div id="imageList" class="row ps-0" style="list-style:none; max-width: 1280px;">
        <!-- Las imágenes se cargarán aquí -->
    </div>

    <!-- Controles de paginación -->
    <div id="paginationControls"></div>

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
                    <div>${data.name}</div>
                    <div>${data.email}</div>
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
        
        const form = e.target;
        const formData = new FormData(form);
        const image = document.getElementById('image').files[0];
        formData.append('image', image);        
        
        try {
            const response = await fetch('http://'+location.host+'/api/images', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                },                
                body: formData,
            });
            
            if (response.ok) {
                alert('Imagen subida con éxito');
                location.reload();
                loadImages();
            } 
        } catch (error) {
            console.error('Error:', error);
        }
    });    


    let currentPage = 1;  // Página actual para la paginación
    let searchQuery = '';  // Término de búsqueda

    // Función para cargar imágenes
    async function loadImages() {
        try {
            const response = await fetch(`http://${location.host}/api/images?page=${currentPage}&search=${searchQuery}`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                },
            });

            const data = await response.json();  // Los datos de imágenes y paginación
            const images = data.data;  // Las imágenes actuales
            const pagination = data;  // Datos de paginación

            const imageList = document.getElementById('imageList');
            const paginationControls = document.getElementById('paginationControls');
            imageList.innerHTML = '';  // Limpiar la lista de imágenes
            paginationControls.innerHTML = '';  // Limpiar los controles de paginación

            // Mostrar las imágenes
            images.forEach(image => {
                getUrlImages(image.id);
                const li = document.createElement('div');
                //const imageUrl = `/api/images/${image.id}/view`;  // URL para ver la imagen
                li.innerHTML = `
                    <img id="img-${image.id}" alt="${image.title}" width="200" height="200"><br>
                    <button type="button" data-image-id="${image.id}" class="btn btn-primary my-2 me-3 btn-edit" data-bs-toggle="modal" data-bs-target="#editModal" style="background: #19565b; border:none;">
                        Editar
                    </button>
                    <button type="button" data-image-id="${image.id}" class="btn btn-danger btn-delete" style="background: red; border:none;" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        Eliminar
                    </button><br>
                    <b>${image.title}</b>
                `;
                li.className = 'col-md-3 mb-3';
                imageList.appendChild(li);
            });

            // Mostrar los controles de paginación
            if (pagination.last_page > 1) {
                // Botón de página anterior
                if (pagination.current_page > 1) {
                    paginationControls.innerHTML += `
                        <button class="btn btn-secondary" onclick="changePage(${pagination.current_page - 1})">Anterior</button>
                    `;
                }

                // Botones de páginas
                for (let page = 1; page <= pagination.last_page; page++) {
                    paginationControls.innerHTML += `
                        <button class="btn btn-secondary ${page === pagination.current_page ? 'active' : ''}" onclick="changePage(${page})">${page}</button>
                    `;
                }

                // Botón de página siguiente
                if (pagination.current_page < pagination.last_page) {
                    paginationControls.innerHTML += `
                        <button class="btn btn-secondary" onclick="changePage(${pagination.current_page + 1})">Siguiente</button>
                    `;
                }
            }

            // Agregar los eventos de editar y eliminar
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', (e) => {
                    const imageId = e.target.getAttribute('data-image-id');
                    loadImageData(imageId);  // Cargar los detalles de la imagen en el formulario
                });
            });

            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function (e) {
                    const imageIdToDelete = e.target.getAttribute('data-image-id');
                    loadDeleteData(imageIdToDelete);
                });
            });

        } catch (error) {
            console.error('Error:', error);
        }
    }

    // Cambiar de página
    function changePage(page) {
        currentPage = page;
        loadImages();  // Volver a cargar las imágenes en la nueva página
    }

    // Función de búsqueda
    document.getElementById('searchInput').addEventListener('input', function () {
        searchQuery = this.value;  // Obtener el valor de búsqueda
        currentPage = 1;  // Resetear a la primera página
        loadImages();  // Cargar las imágenes con la nueva búsqueda
    });

    async function loadImageData(imageId) {
        try {
            const response = await fetch(`/api/images/${imageId}`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                },
            });

            if (response.ok) {
                const imageData = await response.json();
                // Cargar los datos de la imagen en el formulario
                getUrlImages(imageData.id);
                document.getElementById('editTitle').value = imageData.title;  // Título
                document.getElementById('editDescription').value = imageData.description;  // Descripción
                document.getElementById('editImageId').value = imageData.id;  // Descripción

            } else {
                console.error('Error al cargar los datos de la imagen:', response);
                alert('No se pudieron cargar los datos de la imagen');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async function loadDeleteData(imageId) {
        try {
            const response = await fetch(`/api/images/${imageId}`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                },
            });

            if (response.ok) {
                const imageData = await response.json();
                // Cargar los datos de la imagen en el formulario
                document.getElementById('deleteImageId').value = imageData.id;  // Descripción

            } else {
                console.error('Error al cargar los datos de la imagen:', response);
                alert('No se pudieron cargar los datos de la imagen');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    document.getElementById('editForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        
        const imageId = document.getElementById('editImageId').value;  // Obtener el ID de la imagen
        const title = document.getElementById('editTitle').value;
        const description = document.getElementById('editDescription').value;       

        try {
            const response = await fetch(`/api/images/${imageId}`, {
                method: 'PUT',  // Usamos PUT para actualizar
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',  // Asegúrate de establecer el tipo correcto
                },
                body: JSON.stringify({
                    title: title,
                    description: description
                })
            });

            if (response.ok) {
                alert('Imagen actualizada con éxito');
                location.reload();
            } else {
                alert('Error al actualizar la imagen');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });    

    // Confirmar eliminación
    document.getElementById('confirmDeleteBtn').addEventListener('click', async function () {
        const imageId = document.getElementById('deleteImageId').value;  // Obtener el ID de la imagen
        try {
            const response = await fetch(`/api/images/${imageId}`, {
                method: 'DELETE',  // Usamos DELETE para eliminar la imagen
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                }
            });

            if (response.ok) {
                alert('Imagen eliminada con éxito');
                loadImages();  // Recargar las imágenes
                location.reload();
            } else {
                alert('Error al eliminar la imagen');
            }
        } catch (error) {
            console.error('Error:', error);
        }
        
    });




    async function getUrlImages(imageId) {
        try {
            const response = await fetch('/api/images/'+imageId+'/view', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                },
            });

            const imageData = await response.blob();
            const objectURL = URL.createObjectURL(imageData);
            document.getElementById('img-'+imageId).src = objectURL;
            document.getElementById('editImg').src = objectURL;
        } catch (error) {
            // Si hay un error en la solicitud
            document.getElementById('error-message').innerText = error;
        }
    }

    

    // Cargar las imágenes cuando la página cargue
    loadImages();
</script>
@endsection
