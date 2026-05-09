<?php include 'header.php'; ?>

        <!-- Main Layout -->
        <div class="main-layout">
            <?php include 'sidebar_left.php'; ?>

            <!-- Main Content -->
            <main class="content">
                <!-- Trending Section -->
                <section class="trending">
                    <div class="section-header">
                        <h2>Todos nuestros videojuegos</h2>
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
<?php include 'cart_panel.php'; ?>

    <script src="../js/carrito.js?v=<?php echo time(); ?>"></script>
    <script src="../js/main.js?v=<?php echo time(); ?>"></script>
    <script src="../js/agregar.js?v=<?php echo time(); ?>"></script>
    <script src="../js/editar.js?v=<?php echo time(); ?>"></script>
    
</body>
</html>
