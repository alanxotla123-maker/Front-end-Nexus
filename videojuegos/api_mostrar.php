<?php
include("../Conexion/conexion.php");
header('Content-Type: application/json');

$videojuegos = array();
try {
    $sql = "SELECT v.*, GROUP_CONCAT(CONCAT(p.nombre_plaforma, ':', p.stock) SEPARATOR '|') as plataformas_info 
            FROM videojuegos v 
            LEFT JOIN platormas p ON v.id = p.id_videojuego
            GROUP BY v.id";
    $resultado = mysqli_query($conexion, $sql);
    if (!$resultado) {
        echo json_encode(["status" => "error", "message" => mysqli_error($conexion)]);
        exit();
    }
    while($fila = mysqli_fetch_assoc($resultado)) {
        $videojuegos[] = $fila;
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    exit();
}

echo json_encode(!empty($videojuegos) ? $videojuegos : null);
$conexion->close();
?>
