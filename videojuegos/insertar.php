<?php
session_start();
include("../Conexion/conexion.php");
header('Content-Type: application/json');

// Verificar si el usuario es admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
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

    $sql = "INSERT INTO videojuegos (titulo, descripcion, precio, clasificacion, video_path, imagen) 
            VALUES ('$titulo', '$descripcion', '$precio', '$clasificacion', '$video_path', '$imagen')";

    if (mysqli_query($conexion, $sql)) {
        echo json_encode(["status" => "success", "message" => "Videojuego agregado correctamente"]);
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Error al insertar: " . mysqli_error($conexion)]);
    }
} else {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Datos no válidos"]);
}

mysqli_close($conexion);
?>
