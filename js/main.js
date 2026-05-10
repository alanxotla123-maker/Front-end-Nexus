// Archivo principal de JavaScript

document.addEventListener('DOMContentLoaded', () => {
    // Solo cargar videojuegos automáticamente si estamos en la página principal
    if (window.location.pathname.includes('index.php') || window.location.pathname.endsWith('/')) {
        const urlParams = new URLSearchParams(window.location.search);
        const filterParam = urlParams.get('filter');
        cargarVideojuegos(filterParam || 'Todas');
    }
});

// Variable global para usar en otros archivos si es necesario
let videojuegos = [];
let clasificacionActual = 'Todas';

function cargarVideojuegos(filtro = 'Todas') {
    clasificacionActual = filtro;

    fetch('../videojuegos/api_mostrar.php')
        .then(response => response.json())
        .then(data => {

            videojuegos = data;
            const grid = document.querySelector('.game-grid');
            grid.innerHTML = '';

            // Filtrar los videojuegos localmente
            const juegosFiltrados = filtro === 'Todas' 
                ? videojuegos 
                : videojuegos.filter(j => j.clasificacion === filtro);

            juegosFiltrados.forEach((juego) => {
                const card = document.createElement('div');
                card.className = 'game-card';

                // Usamos la imagen de la base de datos, si no tiene, usamos una por defecto
                let imgUrl = juego.imagen;
                if (!imgUrl || imgUrl.startsWith('file:///')) {
                    imgUrl = 'https://via.placeholder.com/300x400?text=Sin+Imagen';
                }

                const rating = (Math.random() * (5 - 4) + 4).toFixed(1);
                card.style.cursor = 'pointer';
                card.onclick = () => window.location.href = 'detalles.php?id=' + juego.id;

                card.innerHTML = `
                    <div class="card-image" style="background-image: url('${imgUrl}'); background-size: cover; position: relative;">
                    </div>
                    <div class="card-info">
                        <div class="card-title-row">
                            <h4>${juego.titulo}</h4>
                            <span class="star">★ ${rating}</span>
                        </div>
                        <span class="genre">${juego.descripcion || 'General'}</span>
                        <div class="card-bottom" style="display: flex; align-items: center; justify-content: space-between; margin-top: 15px;">
                            <span class="card-price" style="font-weight: bold; font-size: 1.1em; color: #00d2ff;">$${juego.precio}</span>
                            <div style="display: flex; gap: 8px;">
                                <button class="btn-add-cart" data-id="${juego.id}" data-titulo="${juego.titulo}" data-precio="${juego.precio}" data-imagen="${juego.imagen || ''}" title="Agregar al carrito" style="background-color: rgba(0,240,255,0.1); border: 1px solid rgba(0,240,255,0.35); border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s; color: #00f0ff;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                // Conectar botón carrito con addEventListener (evita problemas de comillas)
                const btnCart = card.querySelector('.btn-add-cart');
                btnCart.addEventListener('click', (e) => {
                    e.stopPropagation();
                    agregarAlCarrito(juego.id, juego.titulo, juego.precio, juego.imagen || '');
                });

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

window.eliminarJuego = function (id) {
    if (confirm('¿Seguro que quieres eliminar este videojuego?')) {
        fetch(`../videojuegos/eliminar.php?id=${parseInt(id)}`)
            .then(response => {
                cargarVideojuegos();
            })
            .catch(error => {
                console.error('Error al eliminar el videojuego:', error);
            });
    }
}
function cargarPuntos() {
    fetch('../videojuegos/api_mostrar.php')
        .then(response => response.json())
        .then(data => {
            const puntos = data.puntos;
            document.getElementById('puntos').innerText = puntos;
        })
        .catch(error => {
            console.error('Error al cargar los puntos:', error);
        });
}
// Función para filtrar por clasificación desde el sidebar
window.filtrarPorClasificacion = function(clasificacion) {
    // Si no estamos en index.php, redirigir a index.php con el filtro
    if (!window.location.pathname.includes('index.php') && !window.location.pathname.endsWith('/pages/')) {
        window.location.href = 'index.php?filter=' + encodeURIComponent(clasificacion);
        return;
    }

    // Actualizar clase activa en el sidebar
    const items = document.querySelectorAll('#classification-list li');
    items.forEach(item => {
        if (item.innerText.trim() === clasificacion) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });

    cargarVideojuegos(clasificacion);
}
