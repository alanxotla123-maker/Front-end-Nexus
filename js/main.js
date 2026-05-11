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
            if (data && data.status === 'error') {
                console.error('Error de API:', data.message);
                const grid = document.querySelector('.game-grid');
                grid.innerHTML = `<p style="grid-column: 1/-1; text-align: center; color: #ff4d4d; padding: 40px;">⚠️ Error: ${data.message}</p>`;
                return;
            }

            videojuegos = data || [];
            const grid = document.querySelector('.game-grid');
            grid.innerHTML = '';

            // Si no hay juegos, mostrar un mensaje
            if (videojuegos.length === 0) {
                grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; color: var(--text-muted); padding: 40px;">No hay videojuegos disponibles en este momento.</p>';
                return;
            }

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

                // Parsear plataformas y stock
                const plataformasArr = juego.plataformas_info ? juego.plataformas_info.split('|').map(p => {
                    const [nombre, stock] = p.split(':');
                    return { nombre, stock: parseInt(stock) };
                }) : [];

                const platformsHtml = plataformasArr.length > 0 
                    ? plataformasArr.map(p => `<span style="display:block; margin-top:2px;">• ${p.nombre} (Stock: ${p.stock})</span>`).join('')
                    : 'No hay plataformas disponibles';

                card.innerHTML = `
                    <div class="card-image" style="background-image: url('${imgUrl}'); background-size: cover; position: relative;">
                    </div>
                    <div class="card-info">
                        <div class="card-title-row">
                            <h4>${juego.titulo}</h4>
                            <span class="star">★ ${rating}</span>
                        </div>
                        <span class="genre">${juego.descripcion || 'General'}</span>
                        <div class="platforms" style="font-size: 10px; color: var(--accent-cyan); margin-top: 5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                            ${platformsHtml}
                        </div>
                        <div class="card-bottom" style="display: flex; align-items: center; justify-content: space-between; margin-top: 15px;">
                            <span class="card-price" style="font-weight: bold; font-size: 1.1em; color: #00d2ff;">$${juego.precio}</span>
                            <div style="display: flex; gap: 8px;">
                                <button class="btn-add-cart" title="Agregar al carrito" style="background-color: rgba(0,240,255,0.1); border: 1px solid rgba(0,240,255,0.35); border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s; color: #00f0ff;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                </button>
                            </div>
                        </div>
                        ${window.userRol == 1 ? `
                        <div class="admin-actions" style="display: flex; gap: 8px; justify-content: flex-end; margin-top: 10px;">
                            <button class="btn-edit" title="Editar juego" onclick="event.stopPropagation(); abrirModalEditar(${juego.id})" style="background-color: rgba(255,193,7,0.1); border: 1px solid rgba(255,193,7,0.35); border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s; color: #ffc107;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </button>
                            <button class="btn-delete" title="Eliminar juego" onclick="event.stopPropagation(); eliminarJuego(${juego.id})" style="background-color: rgba(220,53,69,0.1); border: 1px solid rgba(220,53,69,0.35); border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s; color: #dc3545;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3,6 5,6 21,6"></polyline><path d="M19,6v14a2,2 0 0 1-2,2H7a2,2 0 0 1-2-2V6m3,0V4a2,2 0 0 1,2-2h4a2,2 0 0 1,2,2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            </button>
                        </div>
                        ` : ''}
                    </div>
                `;

                // Conectar botón carrito con addEventListener
                const btnCart = card.querySelector('.btn-add-cart');
                btnCart.addEventListener('click', (e) => {
                    e.stopPropagation();
                    
                    if (plataformasArr.length === 0) {
                        alert('Este juego no tiene plataformas disponibles.');
                        return;
                    }

                    // Simple prompt para elegir plataforma
                    const opciones = plataformasArr.map((p, i) => `${i + 1}. ${p.nombre} (Stock: ${p.stock})`).join('\n');
                    const seleccion = prompt(`Selecciona una plataforma para ${juego.titulo}:\n\n${opciones}`);
                    
                    if (seleccion === null) return; // Cancelado

                    const index = parseInt(seleccion) - 1;
                    if (plataformasArr[index]) {
                        const platSeleccionada = plataformasArr[index];
                        if (platSeleccionada.stock <= 0) {
                            alert('Lo sentimos, esta plataforma no tiene stock disponible.');
                        } else {
                            agregarAlCarrito(juego.id, juego.titulo, juego.precio, juego.imagen || '', platSeleccionada.nombre);
                        }
                    } else {
                        alert('Selección no válida.');
                    }
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

        // Llenar las plataformas existentes
        const platContainer = document.getElementById('edit-plataformas-container');
        platContainer.innerHTML = '';
        
        if (juego.plataformas_info) {
            const plataformas = juego.plataformas_info.split('|').filter(p => p.trim());
            plataformas.forEach(plat => {
                const [nombre, stock] = plat.split(':');
                const row = document.createElement('div');
                row.className = 'plataforma-row';
                row.style.display = 'flex';
                row.style.gap = '10px';
                row.style.alignItems = 'center';
                row.innerHTML = `
                    <input type="text" name="plataforma[]" value="${nombre.trim()}" placeholder="Ej: PS5, PC, Xbox" style="flex: 2;">
                    <input type="number" name="stock[]" value="${stock.trim()}" placeholder="Stock" style="flex: 1;" min="0">
                    <button type="button" class="remove-platform" style="background: rgba(255,0,0,0.1); border: 1px solid rgba(255,0,0,0.2); color: #ff4d4d; border-radius: 6px; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; cursor: pointer;">×</button>
                `;
                platContainer.appendChild(row);
            });
        } else {
            // Si no hay plataformas, agregar una fila vacía
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
            platContainer.appendChild(row);
        }

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
window.filtrarPorClasificacion = function (clasificacion) {
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
