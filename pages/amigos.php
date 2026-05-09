<?php include 'header.php'; ?>

<!-- Main Layout -->
<div class="main-layout">
    <?php include 'sidebar_left.php'; ?>

    <!-- Main Content -->
    <main class="content">
        <!-- Friends Section -->
        <section class="trending">
            <div class="section-header">
                <h2>Explorar Perfiles</h2>
                <span class="see-all">Comunidad Nexus</span>
            </div>

            <div class="game-grid">
                <?php
                include(__DIR__ . '/../Conexion/conexion.php');
                
                // Obtenemos el ID del usuario actual para excluirlo si queremos
                $mi_id = isset($_SESSION['usuario_id']) ? intval($_SESSION['usuario_id']) : 0;

                // Consulta básica para evitar errores si la columna 'rol' no existe aún
                $sql_usuarios = "SELECT * FROM usuarios WHERE id != $mi_id";
                $res_usuarios = mysqli_query($conexion, $sql_usuarios);

                if ($res_usuarios && mysqli_num_rows($res_usuarios) > 0) {
                    while ($user = mysqli_fetch_assoc($res_usuarios)) {
                        // Filtrar por rol en PHP: Solo mostrar si NO es admin
                        if (isset($user['rol']) && $user['rol'] === 'admin') {
                            continue;
                        }
                        
                        // Generar un avatar aleatorio o usar uno por defecto
                        $avatar_url = "https://api.dicebear.com/7.x/avataaars/svg?seed=" . urlencode($user['nombre']);
                        $user_puntos = number_format($user['puntos'] ?? 0);
                        
                        echo '
                        <div class="game-card" style="padding: 10px; text-align: center;">
                            <div class="card-image" style="background-image: url(\'' . $avatar_url . '\'); background-size: contain; background-repeat: no-repeat; background-position: center; height: 180px; background-color: rgba(255,255,255,0.03); border-radius: 12px; margin-bottom: 15px;">
                                <div class="discount" style="background: var(--accent-cyan); color: #000;">LVL ' . rand(1, 99) . '</div>
                            </div>
                            <div class="card-info" style="padding: 10px 0;">
                                <h4 style="font-size: 18px; margin-bottom: 5px; color: var(--text-main);">' . htmlspecialchars($user['nombre']) . '</h4>
                                <span class="genre" style="color: var(--accent-cyan); font-weight: 600; margin-bottom: 15px;">' . $user_puntos . ' Puntos</span>
                                
                                <div style="display: flex; gap: 10px; justify-content: center; margin-top: 10px;">
                                    <button class="btn-solid" style="padding: 8px 15px; font-size: 11px; width: 100%;">
                                        SEGUIR
                                    </button>
                                </div>
                            </div>
                        </div>';
                    }
                } else {
                    echo '<p style="color: var(--text-muted); text-align: center; grid-column: span 4; padding: 50px;">No se encontraron otros perfiles en este momento.</p>';
                }
                ?>
            </div>
        </section>
    </main>

    <?php include 'sidebar_right.php'; ?>
</div>

<?php include 'footer.php'; ?>
<?php include 'cart_panel.php'; ?>

<script src="../js/carrito.js?v=<?php echo time(); ?>"></script>
<script src="../js/main.js?v=<?php echo time(); ?>"></script>

</body>
</html>
