<?php 
include '../Conexion/conexion.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT * FROM videojuegos WHERE id = $id";
$resultado = mysqli_query($conexion, $sql);
$juego = mysqli_fetch_assoc($resultado);

if (!$juego) {
    header("Location: index.php");
    exit();
}

$imgUrl = $juego['imagen'];
if (!$imgUrl || strpos($imgUrl, 'file:///') === 0) {
    $imgUrl = 'https://via.placeholder.com/1200x500?text=Sin+Imagen';
}

$videoUrl = '';
if (!empty($juego['video_path'])) {
    $videoPath = $juego['video_path'];
    // Convertir enlace normal de youtube a formato embed
    if (strpos($videoPath, 'youtube.com/watch?v=') !== false) {
        $videoUrl = str_replace('watch?v=', 'embed/', $videoPath);
        // Quitar parámetros extra si los hay
        if (($pos = strpos($videoUrl, '&')) !== false) {
            $videoUrl = substr($videoUrl, 0, $pos);
        }
    } else if (strpos($videoPath, 'youtu.be/') !== false) {
        $videoUrl = str_replace('youtu.be/', 'youtube.com/embed/', $videoPath);
        if (($pos = strpos($videoUrl, '?')) !== false) {
            $videoUrl = substr($videoUrl, 0, $pos);
        }
    } else {
        $videoUrl = $videoPath; // Por si ya es embed o es otra plataforma
    }
}
?>
<?php include 'header.php'; ?>

<!-- Main Layout -->
<div class="main-layout">
    <?php include 'sidebar_left.php'; ?>

    <!-- Main Content -->
    <main class="content">
        <section class="game-details" style="background: rgba(255, 255, 255, 0.05); border-radius: 15px; padding: 30px; margin-bottom: 30px; animation: fadeIn 0.5s ease-out;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1 style="font-size: 2.5rem; color: #fff; margin: 0;"><?php echo htmlspecialchars($juego['titulo']); ?></h1>
                <a href="index.php" class="btn-outline" style="text-decoration: none; padding: 10px 20px;">Volver</a>
            </div>

            <?php if ($videoUrl): ?>
                <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 15px; margin-bottom: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                    <iframe src="<?php echo htmlspecialchars($videoUrl); ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;" allowfullscreen></iframe>
                </div>
            <?php else: ?>
                <div style="height: 400px; background-image: url('<?php echo htmlspecialchars($imgUrl); ?>'); background-size: cover; background-position: center; border-radius: 15px; margin-bottom: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                </div>
            <?php endif; ?>

            <div style="display: flex; gap: 30px; flex-wrap: wrap;">
                <div style="flex: 2; min-width: 300px;">
                    <h3 style="color: #00d2ff; margin-bottom: 10px; font-size: 1.5rem;">Descripción</h3>
                    <p style="line-height: 1.8; color: #b0b0b0; font-size: 1.1rem; white-space: pre-wrap;"><?php echo htmlspecialchars($juego['descripcion']); ?></p>
                </div>
                <div style="flex: 1; min-width: 250px; background: rgba(0,0,0,0.3); padding: 20px; border-radius: 15px; display: flex; flex-direction: column; justify-content: center;">
                    <div style="margin-bottom: 15px;">
                        <span style="color: #888; font-size: 0.9rem; display: block; text-transform: uppercase; letter-spacing: 1px;">Precio</span>
                        <span style="font-size: 2.5rem; font-weight: bold; color: #00d2ff;">$<?php echo htmlspecialchars($juego['precio']); ?></span>
                    </div>
                    <div style="margin-bottom: 25px;">
                        <span style="color: #888; font-size: 0.9rem; display: block; text-transform: uppercase; letter-spacing: 1px;">Clasificación</span>
                        <span style="background: rgba(255,255,255,0.1); padding: 8px 15px; border-radius: 8px; font-weight: bold; color: #fff; display: inline-block; margin-top: 5px; font-size: 1.1rem;"><?php echo htmlspecialchars($juego['clasificacion'] ?: 'Pendiente'); ?></span>
                    </div>
                    <button class="btn-solid" style="width: 100%; padding: 15px; font-size: 1.1rem; margin-bottom: 10px; border-radius: 8px;">COMPRAR AHORA</button>
                    <button class="btn-outline" style="width: 100%; padding: 15px; font-size: 1.1rem; border-radius: 8px;">AGREGAR AL CARRITO</button>
                </div>
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
