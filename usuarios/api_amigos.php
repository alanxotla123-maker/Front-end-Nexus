<?php
session_start();
include("../Conexion/conexion.php");

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'No iniciado sesión']);
    exit;
}

$mi_id = intval($_SESSION['usuario_id']);
$accion = $_POST['accion'] ?? '';
$amigo_id = isset($_POST['amigo_id']) ? intval($_POST['amigo_id']) : 0;

if ($amigo_id <= 0 || $mi_id == $amigo_id) {
    echo json_encode(['success' => false, 'message' => 'ID de amigo inválido']);
    exit;
}

if ($accion === 'agregar') {
    $sql = "INSERT IGNORE INTO amistades (id_usuario_1, id_usuario_2) VALUES ($mi_id, $amigo_id)";
    if (mysqli_query($conexion, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Amigo agregado']);
    } else {
        echo json_encode(['success' => false, 'message' => mysqli_error($conexion)]);
    }
} elseif ($accion === 'quitar') {
    $sql = "DELETE FROM amistades WHERE (id_usuario_1 = $mi_id AND id_usuario_2 = $amigo_id) OR (id_usuario_1 = $amigo_id AND id_usuario_2 = $mi_id)";
    if (mysqli_query($conexion, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Amigo eliminado']);
    } else {
        echo json_encode(['success' => false, 'message' => mysqli_error($conexion)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Acción no válida']);
}

mysqli_close($conexion);
?>
