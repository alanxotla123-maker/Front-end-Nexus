// Lógica para el modal y la inserción de videojuegos
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('game-modal');
    const openBtn = document.getElementById('open-modal-btn');
    const closeBtn = document.querySelector('.close-modal');
    const form = document.getElementById('add-game-form');

    // Abrir modal
    openBtn.addEventListener('click', () => {
        modal.classList.add('active');
    });

    // Cerrar modal al hacer clic en la X
    closeBtn.addEventListener('click', () => {
        modal.classList.remove('active');
    });

    // Cerrar modal al hacer clic fuera del contenido
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });

    // Manejar el envío del formulario
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Obtener los datos del formulario
        const formData = new FormData(form);
        const data = {
            titulo: formData.get('titulo'),
            descripcion: formData.get('descripcion'),
            precio: formData.get('precio'),
            clasificacion: formData.get('clasificacion'),
            video_path: formData.get('video_path'),
            imagen: formData.get('imagen')
        };

        try {
            // Enviamos los datos a insertar.php
            const response = await fetch('../videojuegos/insertar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.status === 'success') {
                alert('¡Videojuego registrado con éxito!');
                form.reset();
                modal.classList.remove('active');

                // Recargar la lista de juegos
                if (typeof cargarVideojuegos === 'function') {
                    cargarVideojuegos();
                } else {
                    location.reload();
                }
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error al guardar:', error);
            alert('Hubo un error al guardar el videojuego.');
        }
    });
});
