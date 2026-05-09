<!-- ===== CART PANEL ===== -->
<div id="cart-overlay" onclick="cerrarCarrito()" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); backdrop-filter:blur(4px); z-index:1100;"></div>

<aside id="cart-panel" style="display:none; position:fixed; top:0; right:0; width:400px; max-width:95vw; height:100vh; background:#161b22; border-left:1px solid #30363d; z-index:1200; flex-direction:column; box-shadow:-10px 0 40px rgba(0,0,0,0.5);">
    <div style="display:flex; justify-content:space-between; align-items:center; padding:22px 24px; border-bottom:1px solid #30363d;">
        <div style="display:flex; align-items:center; gap:10px; color:#00f0ff;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            <h2 style="font-size:18px; color:#f0f6fc; margin:0;">Mi Carrito</h2>
        </div>
        <button onclick="cerrarCarrito()" title="Cerrar carrito" style="background:rgba(255,255,255,0.05); border:1px solid #30363d; color:#8b949e; width:34px; height:34px; border-radius:8px; display:flex; align-items:center; justify-content:center; cursor:pointer;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>

    <!-- Empty state -->
    <div id="cart-empty" style="flex:1; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:12px; color:#8b949e; padding:40px;">
        <div style="width:80px; height:80px; background:rgba(0,240,255,0.06); border:1px solid rgba(0,240,255,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center; color:rgba(0,240,255,0.4); margin-bottom:8px;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
        </div>
        <p style="font-size:16px; font-weight:600; color:#f0f6fc; margin:0;">Tu carrito está vacío</p>
        <span style="font-size:13px;">Agrega juegos para comenzar</span>
    </div>

    <!-- Items list -->
    <div id="cart-items" style="flex:1; overflow-y:auto; padding:16px 24px; display:flex; flex-direction:column; gap:14px;"></div>

    <!-- Footer -->
    <div id="cart-footer" style="display:none; padding:20px 24px; border-top:1px solid #30363d;">
        <div style="margin-bottom:16px; display:flex; flex-direction:column; gap:8px;">
            <div style="display:flex; justify-content:space-between; font-size:13px; color:#8b949e;">
                <span>Subtotal</span>
                <span id="cart-subtotal">$0.00</span>
            </div>
            <div style="display:flex; justify-content:space-between; font-size:13px; color:#8b949e;">
                <span>Descuento</span>
                <span id="cart-discount" style="color:#00f0ff;">-$0.00</span>
            </div>
            <div style="display:flex; justify-content:space-between; font-size:16px; font-weight:700; color:#f0f6fc; padding-top:10px; border-top:1px solid #30363d; margin-top:4px;">
                <span>Total</span>
                <span id="cart-total">$0.00</span>
            </div>
        </div>
        <button onclick="procesarCompra()" style="width:100%; background:#00f0ff; border:none; color:#000; padding:14px; border-radius:10px; font-weight:800; font-size:14px; display:flex; align-items:center; justify-content:center; gap:8px; cursor:pointer; box-shadow:0 0 20px rgba(0,240,255,0.3); margin-bottom:10px; font-family:inherit;">
            COMPRAR AHORA
        </button>
        <button onclick="vaciarCarrito()" style="width:100%; background:transparent; border:1px solid rgba(255,255,255,0.1); color:#8b949e; padding:10px; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer; font-family:inherit;">
            Vaciar carrito
        </button>
    </div>
</aside>

<!-- Toast notification -->
<div id="cart-toast" style="position:fixed; bottom:30px; left:50%; transform:translateX(-50%) translateY(20px); background:#161b22; border:1px solid rgba(0,240,255,0.3); color:#f0f6fc; padding:12px 24px; border-radius:30px; font-size:13px; font-weight:600; z-index:2000; opacity:0; pointer-events:none; transition:opacity 0.3s, transform 0.3s; box-shadow:0 4px 20px rgba(0,0,0,0.4); white-space:nowrap;"></div>
