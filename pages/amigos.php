<?php include 'header.php'; ?>

<!-- Main Layout -->
<div class="main-layout">
    <?php include 'sidebar_left.php'; ?>

    <!-- Main Content -->
    <main class="content">
        <!-- Suggested Users Section -->
        <section class="trending">
            <div class="section-header">
                <h2>Explorar Comunidad</h2>
                <span class="see-all">Encuentra nuevos amigos en Level Up</span>
            </div>
            <div class="game-grid">
                <?php
                include(__DIR__ . '/../Conexion/conexion.php');
                $mi_id = isset($_SESSION['usuario_id']) ? intval($_SESSION['usuario_id']) : 0;

                // Obtener lista de Amigos para excluir
                $amigos_lista = [$mi_id];
                if ($mi_id > 0) {
                    $res_amigos = mysqli_query($conexion, "SELECT id_usuario_1, id_usuario_2 FROM amistades WHERE id_usuario_1 = $mi_id OR id_usuario_2 = $mi_id");
                    while ($row = mysqli_fetch_assoc($res_amigos)) {
                        $amigos_lista[] = ($row['id_usuario_1'] == $mi_id) ? $row['id_usuario_2'] : $row['id_usuario_1'];
                    }
                }
                $excluir_str = implode(',', array_unique($amigos_lista));

                $sql_sugeridos = "SELECT * FROM usuarios WHERE id NOT IN ($excluir_str) LIMIT 16";
                $res_sugeridos = mysqli_query($conexion, $sql_sugeridos);

                if ($res_sugeridos && mysqli_num_rows($res_sugeridos) > 0) {
                    while ($user = mysqli_fetch_assoc($res_sugeridos)) {
                        if (isset($user['rol']) && $user['rol'] == 1) continue;
                        
                        $avatar_url = "https://api.dicebear.com/7.x/avataaars/svg?seed=" . urlencode($user['nombre']);
                        $user_puntos = number_format($user['puntos'] ?? 0);
                        echo '
                        <div class="game-card" style="padding: 10px; text-align: center;">
                            <div class="card-image" style="background-image: url(\'' . $avatar_url . '\'); background-size: contain; background-repeat: no-repeat; background-position: center; height: 180px; background-color: rgba(255,255,255,0.03); border-radius: 12px; margin-bottom: 15px;">
                                <div class="discount" style="background: #555; color: #000;">LVL ' . rand(1, 99) . '</div>
                            </div>
                            <div class="card-info" style="padding: 10px 0;">
                                <h4 style="font-size: 18px; margin-bottom: 5px; color: var(--text-main);">' . htmlspecialchars($user['nombre']) . '</h4>
                                <span class="genre" style="color: var(--accent-cyan); font-weight: 600; margin-bottom: 15px;">' . $user_puntos . ' Puntos</span>
                                
                                <div style="display: flex; gap: 10px; justify-content: center; margin-top: 10px;">
                                    <button class="btn-solid" style="padding: 8px 15px; font-size: 11px; width: 100%;" onclick="gestionarAmigo(' . $user['id'] . ', \'agregar\')">
                                        AGREGAR AMIGO
                                    </button>
                                </div>
                            </div>
                        </div>';
                    }
                } else {
                    echo '<p style="color: var(--text-muted); padding: 50px; text-align: center; grid-column: span 4;">No hay más perfiles para mostrar en este momento.</p>';
                }
                ?>
            </div>
        </section>
    </main>

    <script>
    function gestionarAmigo(id, accion) {
        const formData = new FormData();
        formData.append('amigo_id', id);
        formData.append('accion', accion);

        fetch('../usuarios/api_amigos.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error al procesar la solicitud');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión');
        });
    }
    </script>

    <?php include 'sidebar_right.php'; ?>
</div>

<?php include 'footer.php'; ?>
<?php include 'cart_panel.php'; ?>

<script src="../js/carrito.js?v=<?php echo time(); ?>"></script>
<script src="../js/main.js?v=<?php echo time(); ?>"></script>

</body>
</html>
