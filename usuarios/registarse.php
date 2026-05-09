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

    $nombre   = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $username = mysqli_real_escape_string($conexion, $_POST['username']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);

    // Verificar que el usuario no exista ya
    $check = mysqli_query($conexion, "SELECT id FROM usuarios WHERE username = '$username'");
    if ($check && mysqli_num_rows($check) > 0) {
        $error = "Ese nombre de usuario ya está registrado";
    } else {
        // Insertar nuevo usuario
        $sql = "INSERT INTO usuarios (username, password) VALUES ('$username', '$password')";
        $resultado = mysqli_query($conexion, $sql);

        if ($resultado) {
            // Obtener el ID del usuario recién creado
            $nuevo_id = mysqli_insert_id($conexion);

            // Guardar datos en la sesión
            $_SESSION['usuario_id'] = $nuevo_id;
            $_SESSION['username']   = $username;
            $_SESSION['rol']        = 'usuario';

            // Redirigir al dashboard principal
            header("Location: ../pages/index.php");
            exit();
        } else {
            $error = "Error al registrar: " . mysqli_error($conexion);
        }
    }

    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Store - Registro</title>
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

            <h1>NEXUS REGISTRO</h1>
            <p class="login-subtitle">Crear cuenta en NEXUS</p>

            <?php if ($error): ?>
                <div class="error-msg">
                    ⚠️ <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="registarse.php" method="POST">
                <label>Nombre</label>
                <div class="input-group">
                    <input type="text" name="nombre" placeholder="Ingresa tu nombre" required autofocus>
                    <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>

                <label>Usuario</label>
                <div class="input-group">
                    <input type="text" name="username" placeholder="Ingresa tu usuario" required>
                    <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
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
                <p>Nexus Gaming Store <a href="login.php" style="color: #00d2ff; text-decoration: none;">¿Ya tienes una cuenta? Iniciar Sesión</a></p>
            </div>
        </div>
    </div>
</body>
</html>
