<?php include 'header.php'; ?>

        <!-- Main Layout -->
        <div class="main-layout">
            <?php include 'sidebar_left.php'; ?>

            <!-- Main Content -->
            <main class="content">
                <!-- Trending Section -->
                <section class="trending">
                    <div class="section-header">
                        <h2>Libreria</h2>
                    </div>
                    <div class="game-grid">
                        <!-- El contenido se cargará dinámicamente con JS -->
                    </div>
                </section>
            </main>

        </div>

<?php include 'footer.php'; ?>
<?php include 'cart_panel.php'; ?>

    <script>window.USUARIO_ID = <?php echo isset($_SESSION['usuario_id']) ? intval($_SESSION['usuario_id']) : 0; ?>;</script>
    <script src="../js/libreria.js"></script>
    <script src="../js/carrito.js"></script>
    
</body>
</html>
