<?php
session_start();
include("../Conexion/conexion.php");
header('Content-Type: application/json');

// Usar ID del GET, o de la sesión, o por defecto 1
$id = isset($_GET['id']) && $_GET['id'] > 0 
    ? intval($_GET['id']) 
    : (isset($_SESSION['usuario_id']) ? intval($_SESSION['usuario_id']) : 1);

$sql = "SELECT v.id, v.titulo, v.descripcion, v.precio, v.imagen, jc.fecha_compra 
        FROM juegos_comprados jc 
        JOIN videojuegos v ON jc.id_videojuego = v.id 
        WHERE jc.id_comprador = $id";

$resultado = mysqli_query($conexion, $sql);

if ($resultado) {
    $videojuegos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    echo json_encode($videojuegos);
} else {
    echo json_encode(['error' => mysqli_error($conexion), 'sql' => $sql]);
}
?>