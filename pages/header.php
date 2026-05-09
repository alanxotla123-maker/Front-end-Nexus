<?php
session_start();
// Obtener los puntos del usuario logueado
$puntos_usuario = 0;
if (isset($_SESSION['usuario_id'])) {
    include(__DIR__ . '/../Conexion/conexion.php');
    $uid = intval($_SESSION['usuario_id']);
    $res = mysqli_query($conexion, "SELECT puntos FROM usuarios WHERE id = $uid");
    if ($res && $fila = mysqli_fetch_assoc($res)) {
        $puntos_usuario = intval($fila['puntos']);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXUS - Gaming Store</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="app-container">
        <!-- Navbar -->
        <header class="navbar">
            <div class="logo-area">
                <div class="logo-icon">N</div>
                <div class="logo-text">
                    <h1>NEXUS</h1>
                    <span>GAMING STORE</span>
                </div>
            </div>
            
            <nav class="main-nav">
                <a href="../pages/index.php">Explore</a>
                <a href="../pages/miLibreria.php">My Library</a>
                <a href="../pages/amigos.php">Friends</a>
                <a href="../pages/perfil.php">Profile</a>
            </nav>

            <div class="user-actions">
                <div class="points">
                    <span class="point-dot"></span> Points: <?php echo number_format($puntos_usuario); ?>
                </div>
                <div class="cart-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                </div>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                <a href="../usuarios/logout.php" class="logout-btn" title="Cerrar Sesión">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    CERRAR SESIÓN
                </a>
                <?php else: ?>
                <a href="../usuarios/login.php" class="logout-btn" title="Iniciar Sesión">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        <polyline points="10 17 15 12 10 7"></polyline>
                        <line x1="15" y1="12" x2="3" y2="12"></line>
                    </svg>
                    INICIAR SESIÓN
                </a>
                <?php endif; ?>
            </div>
        </header>
