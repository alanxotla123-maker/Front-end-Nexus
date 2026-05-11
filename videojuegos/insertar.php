<?php
session_start();
include("../Conexion/conexion.php");
header('Content-Type: application/json');

// Verificar si el usuario es admin
if (!isset($_SESSION['rol']) || !($_SESSION['rol'] == 1 || $_SESSION['rol'] === 'admin')) {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Acceso denegado. Solo administradores pueden agregar videojuegos."]);
    exit();
}

// Obtener datos del cuerpo de la petición (JSON)
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if ($data) {
    $titulo = mysqli_real_escape_string($conexion, $data['titulo']);
    $descripcion = mysqli_real_escape_string($conexion, $data['descripcion']);
    $precio = mysqli_real_escape_string($conexion, $data['precio']);
    $clasificacion = mysqli_real_escape_string($conexion, $data['clasificacion']);
    $video_path = mysqli_real_escape_string($conexion, $data['video_path']);
    $imagen = mysqli_real_escape_string($conexion, $data['imagen']);

    // Iniciar transacción
    mysqli_begin_transaction($conexion);

    try {
        // Ajustado según la imagen: 'trailer' en lugar de 'video_path'
        // Ajustado según la imagen: 'video_path' en lugar de 'trailer'
        // Si no tienes la columna 'imagen', esta consulta fallará. 
        // Asegúrate de que tu tabla 'videojuegos' tenga: id, titulo, descripcion, precio, clasificacion, video_path, imagen
        $sql = "INSERT INTO videojuegos (titulo, descripcion, precio, clasificacion, video_path, imagen) 
                VALUES ('$titulo', '$descripcion', '$precio', '$clasificacion', '$video_path', '$imagen')";
        
        if (!mysqli_query($conexion, $sql)) {
            throw new Exception(mysqli_error($conexion));
        }

        $id_videojuego = mysqli_insert_id($conexion);

        // Insertar plataformas
        if (isset($data['plataformas']) && is_array($data['plataformas'])) {
            foreach ($data['plataformas'] as $plat) {
                $nombre_plat = mysqli_real_escape_string($conexion, $plat['nombre']);
                $stock = intval($plat['stock']);
                
                $sql_plat = "INSERT INTO platoforma (id_videojuegos, nombre_platorma, stock) 
                            VALUES ($id_videojuego, '$nombre_plat', $stock)";
                
                if (!mysqli_query($conexion, $sql_plat)) {
                    throw new Exception(mysqli_error($conexion));
                }
            }
        }

        mysqli_commit($conexion);
        echo json_encode(["status" => "success", "message" => "Videojuego y plataformas registrados correctamente"]);

    } catch (Exception $e) {
        mysqli_rollback($conexion);
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Error en el registro: " . $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Datos no válidos"]);
}

mysqli_close($conexion);
?>
