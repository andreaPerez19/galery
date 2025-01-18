//agregar imagenes
document.getElementById('uploadForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    //obtengo datos del formulario
    const form = e.target;
    const formData = new FormData(form);
    const image = document.getElementById('image').files[0];
    formData.append('image', image); //agrego imagen del formulario
    
    try {
        //llamo al api para crear imagenes
        const response = await fetch('http://'+location.host+'/api/images', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
            },                
            body: formData,
        });
        //mensaje de exito
        if (response.ok) {
            alert('Imagen subida con éxito');
            location.reload();
            loadImages();
        } 
    } catch (error) {
        console.error('Error:', error);
    }
});