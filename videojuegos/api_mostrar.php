<?php
include("../Conexion/conexion.php");
header('Content-Type: application/json');

$sql = "SELECT * FROM videojuegos";
$resultado = mysqli_query($conexion, $sql);

$videojuegos = array();
if ($resultado) {
    while($fila = mysqli_fetch_assoc($resultado)) {
        $videojuegos[] = $fila;
    }
}

echo json_encode($videojuegos);
$conexion->close();
?>
