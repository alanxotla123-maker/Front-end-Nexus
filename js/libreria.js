document.addEventListener('DOMContentLoaded', () => {
    cargarMiLibreria();
});

function cargarMiLibreria() {
    const userId = window.USUARIO_ID || 1;
    const grid = document.querySelector('.game-grid');

    const mostrarVacio = () => {
        grid.innerHTML =
            '<p style="color: var(--text-muted); grid-column: 1/-1; text-align:center; padding: 40px 0;">🎮 Tu librería está vacía. ¡Compra juegos para verlos aquí!</p>';
    };

    console.log("Cargando librería para el usuario:", userId);

    fetch('../videojuegos/mis_videojuegos.php?id=' + userId)
        .then(response => {
            if (!response.ok) throw new Error('Error en la respuesta');
            return response.json();
        })
        .then(data => {
            console.log("Datos de librería recibidos:", data);
            grid.innerHTML = '';

            if (!data || !Array.isArray(data) || data.length === 0) {
                mostrarVacio();
                return;
            }

            data.forEach(juego => {
                const card = document.createElement('div');
                card.className = 'game-card';

                let imgUrl = juego.imagen;
                if (!imgUrl || imgUrl.startsWith('file:///')) {
                    imgUrl = 'https://via.placeholder.com/300x400?text=Sin+Imagen';
                }

                card.innerHTML = `
                    <div class="card-image" style="background-image: url('${imgUrl}'); background-size: cover; position: relative;">
                        <span class="discount" style="background: #00ff88;">COMPRADO</span>
                    </div>
                    <div class="card-info">
                        <div class="card-title-row">
                            <h4>${juego.titulo}</h4>
                        </div>
                        <span class="genre">${juego.descripcion || ''}</span>
                        <div class="card-bottom" style="display: flex; align-items: center; margin-top: 15px;">
                            <span class="card-price" style="font-weight: bold; font-size: 1.1em; color: #00f0ff;">$${juego.precio || '0.00'}</span>
                        </div>
                    </div>
                `;

                grid.appendChild(card);
            });
        })
        .catch(error => {
            console.error('Error al cargar la librería:', error);
            mostrarVacio();
        });
}

