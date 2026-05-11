            <?php
            include_once(__DIR__ . '/../Conexion/conexion.php');
            $mi_id = isset($_SESSION['usuario_id']) ? intval($_SESSION['usuario_id']) : 0;
            
            // 1. Consultar Amigos Reales (usando 'amistades')
            $amigos_reales = [];
            if ($mi_id > 0) {
                $res_amigos = mysqli_query($conexion, "
                    SELECT u.* FROM usuarios u
                    JOIN amistades a ON (u.id = a.id_usuario_2 AND a.id_usuario_1 = $mi_id) 
                                     OR (u.id = a.id_usuario_1 AND a.id_usuario_2 = $mi_id)
                    LIMIT 5
                ");
                if ($res_amigos) {
                    while ($u = mysqli_fetch_assoc($res_amigos)) {
                        $u['es_amigo'] = true;
                        $amigos_reales[] = $u;
                    }
                }
            }

            // 2. Consultar Otros Usuarios (Sugeridos)
            $usuarios_sugeridos = [];
            if ($mi_id > 0) {
                // Obtener IDs de amigos actuales
                $ids_excluir = [$mi_id];
                $res_ids = mysqli_query($conexion, "SELECT id_usuario_1, id_usuario_2 FROM amistades WHERE id_usuario_1 = $mi_id OR id_usuario_2 = $mi_id");
                while($row = mysqli_fetch_assoc($res_ids)) {
                    $ids_excluir[] = $row['id_usuario_1'];
                    $ids_excluir[] = $row['id_usuario_2'];
                }
                $excluir_str = implode(',', array_unique($ids_excluir));

                $res_sugeridos = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id NOT IN ($excluir_str) LIMIT 10");
                
                if ($res_sugeridos) {
                    while ($u = mysqli_fetch_assoc($res_sugeridos)) {
                        if (isset($u['rol']) && $u['rol'] == 1) continue;
                        $u['es_amigo'] = false;
                        $usuarios_sugeridos[] = $u;
                        if (count($usuarios_sugeridos) >= 5) break;
                    }
                }
            }
            ?>
            <!-- Right Sidebar -->
            <aside class="sidebar-right">
                <div class="friends-list">
                    <div class="friends-header">
                        <h2>FRIENDS</h2>
                        <span class="online-count"><?php echo count($amigos_reales); ?> ONLINE</span>
                    </div>
                    <?php
                    if (count($amigos_reales) > 0):
                        foreach ($amigos_reales as $friend):
                            $f_avatar = "https://api.dicebear.com/7.x/avataaars/svg?seed=" . urlencode($friend['nombre']);
                    ?>
                        <div class="friend-item" style="display: flex; align-items: center; justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div class="avatar online" style="background-image: url('<?php echo $f_avatar; ?>'); background-size: cover; background-color: #222;"></div>
                                <div class="friend-info">
                                    <h4><?php echo htmlspecialchars($friend['nombre']); ?></h4>
                                    <span class="playing-status">Online</span>
                                </div>
                            </div>
                            <button onclick="quitarAmigoSidebar(<?php echo $friend['id']; ?>)" title="Eliminar Amigo" style="background: none; border: none; color: #d9534f; cursor: pointer; padding: 5px; opacity: 0.6; transition: 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.6'">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </div>
                    <?php 
                        endforeach; 
                    else:
                    ?>
                        <p style="font-size: 11px; color: var(--text-muted); margin-bottom: 20px;">No tienes amigos agregados.</p>
                    <?php endif; ?>

                    <!-- SUGGESTIONS SECTION -->
                    <div class="friends-header" style="margin-top: 25px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 20px;">
                        <h2>SUGGESTIONS</h2>
                    </div>
                    <?php
                    if (count($usuarios_sugeridos) > 0):
                        foreach ($usuarios_sugeridos as $suggested):
                            $s_avatar = "https://api.dicebear.com/7.x/avataaars/svg?seed=" . urlencode($suggested['nombre']);
                    ?>
                        <div class="friend-item" style="opacity: 0.8;">
                            <div class="avatar" style="background-image: url('<?php echo $s_avatar; ?>'); background-size: cover; background-color: #222; filter: grayscale(0.5);"></div>
                            <div class="friend-info">
                                <h4 style="font-size: 13px;"><?php echo htmlspecialchars($suggested['nombre']); ?></h4>
                                <span class="playing-status" style="color: var(--accent-cyan); font-size: 10px; cursor: pointer;" onclick="window.location.href='amigos.php'">Ver perfil</span>
                            </div>
                        </div>
                    <?php 
                        endforeach; 
                    endif; ?>

                    <button class="view-all-btn" style="margin-top: 20px;" onclick="window.location.href='mis_amigos.php'">VIEW ALL FRIENDS</button>
                    <button class="view-all-btn" style="margin-top: 10px; background: rgba(255,255,255,0.05); color: var(--text-muted);" onclick="window.location.href='amigos.php'">FIND NEW FRIENDS</button>
                </div>
                
                <div class="chat-widget">
                    <div class="chat-header">
                        <h4>CHATS</h4>
                        <span class="unread-dot"></span>
                    </div>
                    <p>Romise: Hey, ready for the raid tonight at 8?</p>
                </div>
            </aside>

            <script>
            function quitarAmigoSidebar(id) {
                if (!confirm('¿Seguro que quieres eliminar a este amigo?')) return;
                
                const formData = new FormData();
                formData.append('amigo_id', id);
                formData.append('accion', 'quitar');

                fetch('../usuarios/api_amigos.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Error al eliminar amigo');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error de conexión');
                });
            }
            </script>
