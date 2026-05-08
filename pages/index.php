<?php include 'header.php'; ?>

        <!-- Main Layout -->
        <div class="main-layout">
            <?php include 'sidebar_left.php'; ?>

            <!-- Main Content -->
            <main class="content">
                <!-- Featured Game -->
                <section class="featured-game">
                    <div class="featured-image" id="featured-img">
                        <div class="play-btn">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M5 3l14 9-14 9V3z"/></svg>
                        </div>
                        <div class="trailer-tags">
                            <span class="live-dot"></span> LIVE TRAILER &nbsp;&nbsp; 4K HDR
                        </div>
                    </div>
                    <div class="featured-info">
                        <h2>Cyber-Pulse: 2077</h2>
                        <p>Intense cybernetic open-world adventure. Explore the neon-soaked streets of Neon-City as a merc for hire.</p>
                        
                        <div class="price-rating">
                            <div class="price">
                                <span class="amount">$49.99</span>
                                <span class="earn">(Earn 500 Points)</span>
                            </div>
                            <div class="rating">
                                <span>Rating:</span>
                                <div class="esrb">M</div>
                                <span>Mature<br>17+</span>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <button class="btn-outline">ADD TO CART</button>
                            <button class="btn-solid">BUY NOW</button>
                            <button class="btn-text">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 5px;"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>
                                GIFT TO FRIEND
                            </button>
                        </div>
                    </div>
                </section>

                <!-- Trending Section -->
                <section class="trending">
                    <div class="section-header">
                        <h2>Trending Now</h2>
                        <a href="#" class="see-all">SEE ALL GAMES</a>
                    </div>
                    <div class="game-grid">
                        <!-- El contenido se cargará dinámicamente con JS -->
                    </div>
                </section>
            </main>

            <?php include 'sidebar_right.php'; ?>
        </div>

<?php include 'footer.php'; ?>
<?php include 'modal_agregar.php'; ?>
<?php include 'modal_editar.php'; ?>

    <script src="../js/main.js"></script>
    <script src="../js/agregar.js"></script>
    <script src="../js/editar.js"></script>
</body>
</html>
