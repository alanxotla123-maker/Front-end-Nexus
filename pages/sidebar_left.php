            <!-- Left Sidebar -->
            <aside class="sidebar-left">
                <div class="categories">
                    <h2>GAME CATEGORIES</h2>
                    <ul>
                        <li><span class="dot"></span> Action</li>
                        <li><span class="dot"></span> RPG</li>
                        <li class="active"><span class="dot"></span> Shooter</li>
                        <li><span class="dot"></span> Indie</li>
                        <li><span class="dot"></span> Strategy</li>
                    </ul>
                </div>
                
                <div class="promo-box">
                    <span class="promo-title">SUMMER SALE</span>
                    <h3>Up to 75% OFF</h3>
                    <button class="promo-btn">VIEW OFFERS</button>
                </div>

                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                <div class="add-game-container" style="margin-top: 20px;">
                    <button id="open-modal-btn" class="promo-btn" style="background-color: var(--text-main); color: var(--bg-dark);">+ AGREGAR JUEGO</button>
                </div>
                <?php endif; ?>
            </aside>
