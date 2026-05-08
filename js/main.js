// Archivo principal de JavaScript

document.addEventListener('DOMContentLoaded', () => {
    cargarVideojuegos();
});

// Variable global para usar en otros archivos si es necesario
let videojuegos = [];

function cargarVideojuegos() {

    fetch('../videojuegos/api_mostrar.php')
        .then(response => response.json())
        .then(data => {
            videojuegos = data;
            const grid = document.querySelector('.game-grid');
            grid.innerHTML = '';

            videojuegos.forEach((juego) => {
                const card = document.createElement('div');
                card.className = 'game-card';

                // Usamos la imagen de la base de datos, si no tiene, usamos una por defecto
                const imgUrl = juego.imagen;
                const rating = (Math.random() * (5 - 4) + 4).toFixed(1);

                card.innerHTML = `
                    <div class="card-image" style="background-image: url('${juego.imagen}'); background-size: cover; position: relative;">
                        <div style="position: absolute; top: 10px; right: 10px; display: flex; gap: 5px;">
                            <span class="edit-btn" onclick="abrirModalEditar(${juego.id})" style="background: rgba(0,0,0,0.6); padding: 5px 8px; border-radius: 5px; cursor: pointer; color: white;">✏️</span>
                            <span class="heart" onclick="eliminarJuego(${juego.id})" style="background: rgba(0,0,0,0.6); padding: 5px 8px; border-radius: 5px; cursor: pointer; color: white;">🗑️</span>
                        </div>
                    </div>
                    <div class="card-info">
                        <div class="card-title-row">
                            <h4>${juego.titulo}</h4>
                            <span class="star">★ ${rating}</span>
                        </div>
                        <span class="genre">${juego.descripcion || 'General'}</span>
                        <div class="card-bottom">   
                            <span class="card-price">$${juego.precio}</span>
                            <button class="add-btn">+</button>
                        </div>
                    </div>
                `;

                grid.appendChild(card);
            });
        })
        .catch(error => {
            console.error('Error al cargar los videojuegos:', error);
        });
}

// Función para poblar y abrir el modal de edición
window.abrirModalEditar = function (id) {
    const juego = videojuegos.find(j => j.id == id);
    if (juego) {
        document.getElementById('edit_id').value = juego.id;
        document.getElementById('edit_titulo').value = juego.titulo;
        document.getElementById('edit_descripcion').value = juego.descripcion;
        document.getElementById('edit_precio').value = juego.precio;
        document.getElementById('edit_clasificacion').value = juego.clasificacion;
        document.getElementById('edit_video_path').value = juego.video_path || '';
        document.getElementById('edit_imagen').value = juego.imagen || '';

        document.getElementById('edit-game-modal').classList.add('active');
    }
}

// Función para eliminar un juego
window.eliminarJuego = function (id) {
    if (confirm('¿Seguro que quieres eliminar este videojuego?')) {
        videojuegos = videojuegos.filter(juego => juego.id !== id);
        localStorage.setItem('videojuegos', JSON.stringify(videojuegos));
        cargarVideojuegos();
    }
}
