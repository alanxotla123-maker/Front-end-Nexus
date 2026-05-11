            <!-- Left Sidebar -->
            <aside class="sidebar-left">
                <?php if (isset($_SESSION['rol']) && ($_SESSION['rol'] == 1 || $_SESSION['rol'] === 'admin')): ?>
                <div class="admin-actions" style="margin-bottom: 20px;">
                    <button id="open-modal-btn" class="promo-btn" style="width: 100%; background: linear-gradient(135deg, #ff6b6b, #ee5a24); border: none; color: white; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: 600;">Agregar Nuevo Juego</button>
                </div>
                <?php endif; ?>
                <div class="categories">
                    <h2>GAME CLASSIFICATIONS</h2>
                    <ul id="classification-list">
                        <li class="active" onclick="filtrarPorClasificacion('Todas')"><span class="dot"></span> Todas</li>
                        <?php
                        include(__DIR__ . '/../Conexion/conexion.php');
                        $res_class = mysqli_query($conexion, "SELECT DISTINCT clasificacion FROM videojuegos WHERE clasificacion IS NOT NULL AND clasificacion != '' ORDER BY clasificacion ASC");
                        while ($row = mysqli_fetch_assoc($res_class)):
                        ?>
                            <li onclick="filtrarPorClasificacion('<?php echo $row['clasificacion']; ?>')">
                                <span class="dot"></span> <?php echo $row['clasificacion']; ?>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                
                <div class="promo-box">
                    <span class="promo-title">SUMMER SALE</span>
                    <h3>Up to 75% OFF</h3>
                    <button class="promo-btn">VIEW OFFERS</button>
                </div>

            </aside>
