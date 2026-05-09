// ============================================================
//  CARRITO DE COMPRAS — Nexus Gaming Store
// ============================================================

// Estado del carrito (persistente en localStorage)
let carrito = JSON.parse(localStorage.getItem('nexus_cart') || '[]');

// ── Abrir / Cerrar panel ──────────────────────────────────────
function abrirCarrito() {
    const panel = document.getElementById('cart-panel');
    const overlay = document.getElementById('cart-overlay');
    panel.style.display = 'flex';
    overlay.style.display = 'block';
    // Pequeño delay para que la animación funcione después del display change
    requestAnimationFrame(() => {
        panel.classList.add('open');
        overlay.classList.add('open');
    });
    document.body.style.overflow = 'hidden';
    renderCarrito();
}

function cerrarCarrito() {
    const panel = document.getElementById('cart-panel');
    const overlay = document.getElementById('cart-overlay');
    panel.classList.remove('open');
    overlay.classList.remove('open');
    document.body.style.overflow = '';
    // Esperar a que termine la animación antes de ocultar
    setTimeout(() => {
        panel.style.display = 'none';
        overlay.style.display = 'none';
    }, 400);
}

// ── Agregar al carrito ────────────────────────────────────────
window.agregarAlCarrito = function (id, titulo, precio, imagen) {
    const item = carrito.find(i => i.id == id);

    if (item) {
        mostrarToast(`⚠️ ${titulo} ya está en el carrito`);
        return;
    }

    carrito.push({ id, titulo, precio: parseFloat(precio), imagen, cantidad: 1 });
    guardarCarrito();
    actualizarBadge();
    mostrarToast(`🎮 ${titulo} agregado al carrito`);
};

// ── Eliminar item ─────────────────────────────────────────────
window.eliminarDelCarrito = function (id) {
    carrito = carrito.filter(i => i.id != id);
    guardarCarrito();
    actualizarBadge();
    renderCarrito();
};

// ── Vaciar carrito ────────────────────────────────────────────
window.vaciarCarrito = function () {
    if (!confirm('¿Vaciar el carrito?')) return;
    carrito = [];
    guardarCarrito();
    actualizarBadge();
    renderCarrito();
};

// ── Procesar compra ───────────────────────────────────────────
window.procesarCompra = function () {
    if (carrito.length === 0) return;

    mostrarToast('✅ ¡Compra realizada con éxito!');
    carrito = [];
    guardarCarrito();
    actualizarBadge();
    renderCarrito();
    setTimeout(cerrarCarrito, 1500);
};

// ── Persistencia ──────────────────────────────────────────────
function guardarCarrito() {
    localStorage.setItem('nexus_cart', JSON.stringify(carrito));
}

// ── Badge en el ícono del navbar ──────────────────────────────
function actualizarBadge() {
    const totalItems = carrito.reduce((sum, i) => sum + i.cantidad, 0);
    const badge = document.getElementById('cart-badge');
    if (!badge) return;

    badge.textContent = totalItems;
    badge.style.display = totalItems > 0 ? 'flex' : 'none';
}

// ── Renderizar items en el panel ──────────────────────────────
function renderCarrito() {
    const list = document.getElementById('cart-items');
    const empty = document.getElementById('cart-empty');
    const footer = document.getElementById('cart-footer');

    list.innerHTML = '';

    if (carrito.length === 0) {
        empty.style.display = 'flex';
        footer.style.display = 'none';
        return;
    }

    empty.style.display = 'none';
    footer.style.display = 'block';

    carrito.forEach(item => {
        const div = document.createElement('div');
        div.className = 'cart-item';

        const imgUrl = (item.imagen && !item.imagen.startsWith('file:///'))
            ? item.imagen
            : 'https://via.placeholder.com/60x60?text=🎮';

        div.innerHTML = `
            <div class="cart-item-img" style="background-image:url('${imgUrl}')"></div>
            <div class="cart-item-info">
                <h4 class="cart-item-title">${item.titulo}</h4>
                <span class="cart-item-price">$${item.precio.toFixed(2)}</span>
            </div>
            <button class="cart-item-remove" onclick="eliminarDelCarrito('${item.id}')" title="Eliminar">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        `;
        list.appendChild(div);
    });

    // Totales
    const subtotal = carrito.reduce((s, i) => s + i.precio * i.cantidad, 0);
    const descuento = subtotal >= 100 ? subtotal * 0.1 : 0;
    const total = subtotal - descuento;

    document.getElementById('cart-subtotal').textContent = `$${subtotal.toFixed(2)}`;
    document.getElementById('cart-discount').textContent = `-$${descuento.toFixed(2)}`;
    document.getElementById('cart-total').textContent = `$${total.toFixed(2)}`;
}

// ── Toast notification ────────────────────────────────────────
function mostrarToast(msg) {
    const toast = document.getElementById('cart-toast');
    toast.textContent = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 3000);
}

// ── Init ──────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    // Conectar ícono del carrito en el navbar
    const cartIconWrapper = document.querySelector('.cart-icon');
    if (cartIconWrapper) {
        cartIconWrapper.style.position = 'relative';
        cartIconWrapper.style.cursor = 'pointer';
        cartIconWrapper.onclick = abrirCarrito;

        // Crear badge
        const badge = document.createElement('span');
        badge.id = 'cart-badge';
        badge.className = 'cart-badge';
        badge.style.display = 'none';
        cartIconWrapper.appendChild(badge);
    }

    // Botón "ADD TO CART" del juego destacado
    const btnAddFeatured = document.querySelector('.btn-outline');
    if (btnAddFeatured) {
        btnAddFeatured.onclick = () => {
            agregarAlCarrito('featured-1', 'Cyber-Pulse: 2077', 49.99,
                'https://via.placeholder.com/60x60?text=CP2077');
        };
    }

    actualizarBadge();
    renderCarrito();
});
