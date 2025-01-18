let currentPage = 1;  // Página actual para la paginación
let searchQuery = '';  // Término de búsqueda

// Función para cargar imágenes
async function loadImages() {
    try {
        //llamo al api para mostrar imagenes
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
            //obtener la url de la imagen privada
            getUrlImages(image.id);
            //listado de imagenes
            const li = document.createElement('div');
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

        // Agregar evento editar
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', (e) => {
                const imageId = e.target.getAttribute('data-image-id');
                loadImageData(imageId);  // Cargar los detalles de la imagen en el formulario
            });
        });
        // Agregar evento eliminar
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

//funcion para obtener url de la imagen
async function getUrlImages(imageId) {
    try {
        //llamar al api para obtener ruta de la imagen
        const response = await fetch('/api/images/'+imageId+'/view', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
            },
        });
        //genero url imagen
        const imageData = await response.blob();
        const objectURL = URL.createObjectURL(imageData);
        document.getElementById('img-'+imageId).src = objectURL;
        document.getElementById('editImg').src = objectURL;
    } catch (error) {
        // Si hay un error en la solicitud
        console.error('Error:', error);
    }
}

// Cargar las imágenes cuando la página cargue
loadImages();