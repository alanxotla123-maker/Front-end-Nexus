            <!-- Left Sidebar -->
            <aside class="sidebar-left">
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
