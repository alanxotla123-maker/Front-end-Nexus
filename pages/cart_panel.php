<!-- ===== CART PANEL ===== -->
<div class="cart-overlay" id="cart-overlay" onclick="cerrarCarrito()" style="display:none;"></div>

<aside class="cart-panel" id="cart-panel" style="display:none;">
    <div class="cart-panel-header">
        <div class="cart-title-row">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            <h2>Mi Carrito</h2>
        </div>
        <button class="cart-close-btn" onclick="cerrarCarrito()" title="Cerrar carrito">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>

    <!-- Empty state -->
    <div class="cart-empty" id="cart-empty">
        <div class="cart-empty-icon">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
        </div>
        <p>Tu carrito está vacío</p>
        <span>Agrega juegos para comenzar</span>
    </div>

    <!-- Items list -->
    <div class="cart-items" id="cart-items"></div>

    <!-- Footer -->
    <div class="cart-footer" id="cart-footer" style="display:none;">
        <div class="cart-summary">
            <div class="cart-summary-row">
                <span>Subtotal</span>
                <span id="cart-subtotal">$0.00</span>
            </div>
            <div class="cart-summary-row">
                <span>Descuento</span>
                <span id="cart-discount" style="color:#00f0ff;">-$0.00</span>
            </div>
            <div class="cart-summary-row total">
                <span>Total</span>
                <span id="cart-total">$0.00</span>
            </div>
        </div>
        <button class="cart-checkout-btn" onclick="procesarCompra()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg>
            COMPRAR AHORA
        </button>
        <button class="cart-clear-btn" onclick="vaciarCarrito()">Vaciar carrito</button>
    </div>
</aside>

<!-- Toast notification -->
<div class="cart-toast" id="cart-toast"></div>
