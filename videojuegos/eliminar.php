
<?php
include("../Conexion/conexion.php");

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM videojuegos WHERE id = $id";
    
    if (mysqli_query($conexion, $sql)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conexion)]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No ID provided"]);
}

mysqli_close($conexion);
?>
