            <?php
            include_once(__DIR__ . '/../Conexion/conexion.php');
            $mi_id = isset($_SESSION['usuario_id']) ? intval($_SESSION['usuario_id']) : 0;
            
            // Intentamos una consulta segura. Si falla por falta de la columna 'rol', hacemos una básica.
            $res_sidebar = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id != $mi_id LIMIT 5");
            
            $amigos_filtrados = [];
            if ($res_sidebar) {
                while ($u = mysqli_fetch_assoc($res_sidebar)) {
                    // Filtrar por rol en PHP para evitar errores de SQL si la columna no existe aún
                    if (!isset($u['rol']) || $u['rol'] !== 'admin') {
                        $amigos_filtrados[] = $u;
                    }
                }
            }
            ?>
            <!-- Right Sidebar -->
            <aside class="sidebar-right">
                <div class="friends-list">
                    <div class="friends-header">
                        <h2>FRIENDS</h2>
                        <span class="online-count"><?php echo count($amigos_filtrados); ?> ONLINE</span>
                    </div>
                    <?php
                    if (count($amigos_filtrados) > 0):
                        foreach ($amigos_filtrados as $friend):
                            $f_avatar = "https://api.dicebear.com/7.x/avataaars/svg?seed=" . urlencode($friend['nombre']);
                    ?>
                        <div class="friend-item">
                            <div class="avatar online" style="background-image: url('<?php echo $f_avatar; ?>'); background-size: cover; background-color: #222;"></div>
                            <div class="friend-info">
                                <h4><?php echo htmlspecialchars($friend['nombre']); ?></h4>
                                <span class="playing-status">Online</span>
                            </div>
                        </div>
                    <?php 
                        endforeach; 
                    else:
                    ?>
                        <p style="font-size: 11px; color: var(--text-muted); margin-bottom: 20px;">No hay otros usuarios.</p>
                    <?php endif; ?>
                    <button class="view-all-btn" onclick="window.location.href='amigos.php'">VIEW ALL FRIENDS</button>
                </div>
                
                <div class="chat-widget">
                    <div class="chat-header">
                        <h4>CHATS</h4>
                        <span class="unread-dot"></span>
                    </div>
                    <p>Romise: Hey, ready for the raid tonight at 8?</p>
                </div>
            </aside>
