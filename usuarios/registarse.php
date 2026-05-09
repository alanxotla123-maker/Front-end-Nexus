<?php
session_start();

// Si ya tiene sesión, redirigir al sistema
if (isset($_SESSION['usuario_id'])) {
    header("Location: ../pages/index.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("../Conexion/conexion.php");

    $username = mysqli_real_escape_string($conexion, $_POST['username']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);

    // Buscar usuario en la tabla 'usuario' o 'usuarios'
    $sql = "INSERT INTO usuarios (username, password, rol) VALUES ('$username', '$password', 'usuario')";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado) {
        // Guardar datos en la sesión
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['username'] = $usuario['username'] ?? $usuario['usario'];
        $_SESSION['rol'] = $usuario['rol'] ?? 'usuario';

        // Redirigir al dashboard principal
        header("Location: ../pages/index.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }

    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Store - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/auth.css">
</head>
<body>
    <div class="login-wrapper">
        <div class="contenedor">
            <div class="login-icon">
                <!-- Gamepad Icon -->
                <svg viewBox="0 0 24 24">
                    <rect x="2" y="6" width="20" height="12" rx="2" ry="2"></rect>
                    <line x1="6" y1="12" x2="10" y2="12"></line>
                    <line x1="8" y1="10" x2="8" y2="14"></line>
                    <line x1="15" y1="13" x2="15.01" y2="13"></line>
                    <line x1="18" y1="11" x2="18.01" y2="11"></line>
                </svg>
            </div>

            <h1>NEXUS LOGON</h1>
            <p class="login-subtitle">Crear cuenta en NEXUS</p>

            <form action="login.php" method="POST">
                <label>Nombre</label>
                <div class="input-group">
                    <input type="text" name="nombre" placeholder="Ingresa tu nombre" required autofocus>
                    <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                 <label>Corre:</label>
                <div class="input-group">
                    <input type="text" name="username" placeholder="Ingresa tu usuario" required autofocus>
                    <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>

                <label>Contraseña</label>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Ingresa tu contraseña" required>
                    <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </div>

                <button type="submit">REGISTRARSE</button>
            </form>

            <div class="login-footer">
                <p>Nexus Gaming Store <a href="login.php"  style="color: #00d2ff; text-decoration: none;">¿Ya tienes una cuenta? Iniciar Sesión</a></p>
            </div>
        </div>
    </div>
</body>
</html>
