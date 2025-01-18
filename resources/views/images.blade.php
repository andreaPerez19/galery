@extends('layouts.layout')

@section('content')
<div>
    <h3 class="text-center my-3"><b>Galería de imágenes</b></h3>
    <!-- Button nuevo -->
    <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background: #19565b; border:none;">
        + Agregar imagen
    </button>
    <!-- fin boton -->

    <!-- Modal nueva imagen-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 740px;">
            <div class="modal-content">
                <!--cabecera modal -->
                <div class="modal-header" style="background: #19565b; color: #fff;">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar imagen</h5>                
                </div>
                <!--fin cabecera -->

                <div class="modal-body">
                    <h6 class="mb-4"><b>Los campos marcados con (*) son obligatorios</b></h6>
                    <!-- Formulario para subir imágenes -->
                    <form id="uploadForm" enctype="multipart/form-data">
                        @csrf
                        <!-- input titulo -->
                        <div class="row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-end">Título <span style="color:red;">*</span></label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- input archivo -->
                        <div class="row mb-3">
                            <label for="image" class="col-md-4 col-form-label text-md-end">Subir imágen <span style="color:red;">*</span></label>

                            <div class="col-md-6">            
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" required>
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- input descripcion -->
                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">Descripción <span style="color:red;">*</span></label>

                            <div class="col-md-6">            
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" rows="3" name="description" value="{{ old('description') }}" required></textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- botones de accion -->
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary me-3" style="background: #19565b; border:none;">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                        
                    </form>
                    <!-- fin formulario -->
                </div>

                <!-- pie de modal -->
                <div class="modal-footer">                                
                </div>
                <!-- fin pie -->
            </div>
        </div>
    </div>
    
    <!-- Modal Editar Imagen -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 740px;">
            <div class="modal-content">
                <!--cabecera modal -->
                <div class="modal-header" style="background: #19565b; color: #fff;">
                    <h5 class="modal-title" id="exampleModalLabel">Editar imagen</h5>                
                </div>
                <!--fin cabecera -->

                <div class="modal-body">
                    <h6 class="mb-4"><b>Los campos marcados con (*) son obligatorios</b></h6>
                    <!-- Formulario para editar imagen -->
                    <form id="editForm">
                        @csrf
                        <input type="hidden" id="editImageId" name="id">  <!-- Campo oculto para el ID de la imagen -->

                        <div class="row mb-3">
                            <!-- mostrar imagen de galeria -->
                            <div class="col-md-2"><img id="editImg" width="150" height="150"/></div>
                            <!-- fin imagen -->
                            <div class="col-md-10">
                                <div class="row">
                                    <!-- input titulo -->
                                    <label for="editTitle" class="col-md-4 col-form-label text-md-end">Título <span style="color:red;">*</span></label>
                                    <div class="col-md-6">
                                        <input id="editTitle" type="text" class="form-control mb-3" name="title" required>
                                    </div>
                                    <!-- input descripcion -->                      
                                    <label for="editDescription" class="col-md-4 col-form-label text-md-end">Descripción <span style="color:red;">*</span></label>
                                    <div class="col-md-6">
                                        <textarea id="editDescription" class="form-control" name="description" required></textarea>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <!-- botones de accion -->
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary me-3" style="background: #19565b; border:none;">Actualizar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                        <!-- fin botones -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 500px;">
            <div class="modal-content">
                <!--cabecera modal -->
                <div class="modal-header" style="background: #19565b; color: #fff;">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                </div>
                <!--fin cabecera -->

                <div class="modal-body">
                    <input type="hidden" id="deleteImageId" name="id">  <!-- Campo oculto para el ID de la imagen -->
                    ¿Estás seguro de que deseas eliminar esta imagen? Esta acción no se puede deshacer.
                </div>

                <!--pie modal botones de accion-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
                </div>
                <!--fin pie -->
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

    <!-- mensajes de error -->
    <div class="error-message" id="error-message"></div>
</div>

<!-- consumo del backend -->
<script src="{{ asset('js/users.js') }}"></script>
<!-- agregar imagenes -->
<script src="{{ asset('js/create-image.js') }}"></script>
<!-- leer imagenes -->
<script src="{{ asset('js/read-image.js') }}"></script>
<!-- actualizar datos de imagen -->
<script src="{{ asset('js/edit-image.js') }}"></script>
<!-- eliminar imagen -->
<script src="{{ asset('js/delete-image.js') }}"></script>
@endsection
