//funcion para obtener la imagen a ser eliminada
async function loadDeleteData(imageId) {
    try {
        //llamada al api
        const response = await fetch(`/api/images/${imageId}`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
            },
        });

        if (response.ok) {
            const imageData = await response.json();
            // Cargar los datos de la imagen en el formulario
            document.getElementById('deleteImageId').value = imageData.id;  // id

        } else {
            console.error('Error al cargar los datos de la imagen:', response);
            alert('No se pudieron cargar los datos de la imagen');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}    

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