document.addEventListener('DOMContentLoaded', () => {
    const editModal = document.getElementById('edit-game-modal');
    const closeEditBtn = document.querySelector('.close-edit-modal');
    const editForm = document.getElementById('edit-game-form');
    const editPlataformasContainer = document.getElementById('edit-plataformas-container');
    const editAddPlatformBtn = document.getElementById('edit-add-platform-btn');

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

    // Agregar plataformas en el modal de edición
    if (editAddPlatformBtn) {
        editAddPlatformBtn.addEventListener('click', () => {
            const row = document.createElement('div');
            row.className = 'plataforma-row';
            row.style.display = 'flex';
            row.style.gap = '10px';
            row.style.alignItems = 'center';
            row.innerHTML = `
                <input type="text" name="plataforma[]" placeholder="Ej: PS5, PC, Xbox" style="flex: 2;">
                <input type="number" name="stock[]" placeholder="Stock" style="flex: 1;" min="0">
                <button type="button" class="remove-platform" style="background: rgba(255,0,0,0.1); border: 1px solid rgba(255,0,0,0.2); color: #ff4d4d; border-radius: 6px; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; cursor: pointer;">×</button>
            `;
            editPlataformasContainer.appendChild(row);
        });
    }

    // Eliminar plataformas en el modal de edición
    if (editPlataformasContainer) {
        editPlataformasContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-platform') || e.target.closest('.remove-platform')) {
                const rows = editPlataformasContainer.querySelectorAll('.plataforma-row');
                if (rows.length > 1) {
                    e.target.closest('.plataforma-row').remove();
                } else {
                    alert('Debe haber al menos una plataforma.');
                }
            }
        });
    }

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
