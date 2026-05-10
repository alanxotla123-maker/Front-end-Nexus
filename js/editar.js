document.addEventListener('DOMContentLoaded', () => {
    const editModal = document.getElementById('edit-game-modal');
    const closeEditBtn = document.querySelector('.close-edit-modal');
    const editForm = document.getElementById('edit-game-form');

    // Cerrar modal al hacer clic en la X
    if (closeEditBtn) {
        closeEditBtn.addEventListener('click', () => {
            editModal.classList.remove('active');
        });
    }

    // Cerrar modal al hacer clic fuera del contenido
    window.addEventListener('click', (e) => {
        if (editModal && e.target === editModal) {
            editModal.classList.remove('active');
        }
    });

    // Enviar el formulario de edición usando fetch para evitar la redirección a mostrar.php
    if (editForm) {
        editForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(editForm);

            try {
                // Mandamos los datos a editar.php
                const response = await fetch('../videojuegos/editar.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.status === 'success') {
                    alert('¡Videojuego actualizado con éxito!');
                    editModal.classList.remove('active');

                    // Recargar la lista de juegos
                    if (typeof cargarVideojuegos === 'function') {
                        cargarVideojuegos();
                    } else {
                        location.reload();
                    }
                } else {
                    alert('Error al actualizar el juego: ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Hubo un problema de conexión al guardar los cambios.');
            }
        });
    }
});
