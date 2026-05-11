<?php
session_start();
include("../Conexion/conexion.php");
header('Content-Type: application/json');

if (!isset($_SESSION['rol']) || !($_SESSION['rol'] == 1 || $_SESSION['rol'] === 'admin')) {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Acceso denegado. Solo administradores pueden editar videojuegos."]);
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST["id"] ?? '';
    $titulo = $_POST["titulo"] ?? '';
    $descripcion = $_POST["descripcion"] ?? '';
    $precio = $_POST["precio"] ?? '';
    $clasificacion = $_POST["clasificacion"] ?? '';
    $video_path = $_POST["video_path"] ?? '';
    $imagen = $_POST["imagen"] ?? '';

    // Escapar para evitar errores con comillas (SQL Injection)
    $id = mysqli_real_escape_string($conexion, $id);
    $titulo = mysqli_real_escape_string($conexion, $titulo);
    $descripcion = mysqli_real_escape_string($conexion, $descripcion);
    $precio = mysqli_real_escape_string($conexion, $precio);
    $clasificacion = mysqli_real_escape_string($conexion, $clasificacion);
    $video_path = mysqli_real_escape_string($conexion, $video_path);
    $imagen = mysqli_real_escape_string($conexion, $imagen);

    // Iniciar transacción
    mysqli_begin_transaction($conexion);

    try {
        $sql = "UPDATE videojuegos SET 
                titulo='$titulo', 
                descripcion='$descripcion', 
                precio='$precio', 
                clasificacion='$clasificacion', 
                video_path='$video_path', 
                imagen='$imagen' 
                WHERE id='$id'";
        
        if (!mysqli_query($conexion, $sql)) {
            throw new Exception(mysqli_error($conexion));
        }

        // Obtener plataformas actuales y eliminarlas para reconstruir
        mysqli_query($conexion, "DELETE FROM platormas WHERE id_videojuego = $id");

        // Insertar nuevas plataformas
        if (isset($_POST['plataforma']) && is_array($_POST['plataforma'])) {
            foreach ($_POST['plataforma'] as $i => $nombre_plat) {
                if (empty($nombre_plat)) continue;
                
                $nombre_plat = mysqli_real_escape_string($conexion, $nombre_plat);
                $stock = isset($_POST['stock'][$i]) ? intval($_POST['stock'][$i]) : 0;
                
                $sql_plat = "INSERT INTO platormas (id_videojuego, nombre_plaforma , stock) 
                            VALUES ($id, '$nombre_plat', $stock)";
                
                if (!mysqli_query($conexion, $sql_plat)) {
                    throw new Exception(mysqli_error($conexion));
                }
            }
        }

        mysqli_commit($conexion);
        echo json_encode(["status" => "success", "message" => "Videojuego actualizado"]);
    } catch (Exception $e) {
        mysqli_rollback($conexion);
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Error al actualizar: " . $e->getMessage()]);
    }
}
mysqli_close($conexion);
?>