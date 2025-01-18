//funcion para obtener los datos a editar
async function loadImageData(imageId) {
    try {
        //lamar al api que obtiene los datos de la imagen
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
            document.getElementById('editImageId').value = imageData.id;  // id

        } else {
            console.error('Error al cargar los datos de la imagen:', response);
            alert('No se pudieron cargar los datos de la imagen');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

//actualizar datos de imagen
document.getElementById('editForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    
    const imageId = document.getElementById('editImageId').value;  // ID de la imagen
    const title = document.getElementById('editTitle').value; // titulo
    const description = document.getElementById('editDescription').value; //descripcion      

    try {
        //llamada al api para actualizar datos de imagen
        const response = await fetch(`/api/images/${imageId}`, {
            method: 'PUT',  // Usamos PUT para actualizar
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',  // establecer el tipo correcto
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