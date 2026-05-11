// Lógica para el modal y la inserción de videojuegos
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('game-modal');
    const openBtn = document.getElementById('open-modal-btn');
    const closeBtn = document.querySelector('.close-modal');
    const form = document.getElementById('add-game-form');

    // Abrir modal
    if (openBtn) {
        openBtn.addEventListener('click', () => {
            modal.classList.add('active');
        });
    }

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

    // --- Lógica de Plataformas ---
    const plataformasContainer = document.getElementById('plataformas-container');
    const addPlatformBtn = document.getElementById('add-platform-btn');

    addPlatformBtn.addEventListener('click', () => {
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
        plataformasContainer.appendChild(row);
    });

    plataformasContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-platform') || e.target.closest('.remove-platform')) {
            const rows = plataformasContainer.querySelectorAll('.plataforma-row');
            if (rows.length > 1) {
                e.target.closest('.plataforma-row').remove();
            } else {
                alert('Debe haber al menos una plataforma.');
            }
        }
    });

    // Manejar el envío del formulario
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Recolectar plataformas
        const plataformas = [];
        const rows = plataformasContainer.querySelectorAll('.plataforma-row');
        rows.forEach(row => {
            const nombre = row.querySelector('input[name="plataforma[]"]').value;
            const stock = row.querySelector('input[name="stock[]"]').value;
            if (nombre) {
                plataformas.push({ nombre, stock: parseInt(stock) || 0 });
            }
        });

        // Obtener los datos del formulario
        const formData = new FormData(form);
        const data = {
            titulo: formData.get('titulo'),
            descripcion: formData.get('descripcion'),
            precio: formData.get('precio'),
            clasificacion: formData.get('clasificacion'),
            video_path: formData.get('video_path'),
            imagen: formData.get('imagen'),
            plataformas: plataformas
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
                // Limpiar filas extras de plataformas
                while (plataformasContainer.children.length > 1) {
                    plataformasContainer.removeChild(plataformasContainer.lastChild);
                }
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
