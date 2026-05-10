<?php
session_start();
include("../Conexion/conexion.php");
header('Content-Type: application/json');

// Verificar que sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// Obtener el ID del usuario (sesión o default 1)
$id_usuario = isset($_SESSION['usuario_id']) ? intval($_SESSION['usuario_id']) : 1;

// Leer los datos del carrito enviados por JS
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['items']) || count($input['items']) === 0) {
    echo json_encode(['error' => 'El carrito está vacío']);
    exit;
}

$items = $input['items'];
$comprados = 0;
$errores = [];

foreach ($items as $item) {
    $id_videojuego = intval($item['id']);
    
    // Verificar que el juego existe
    $check = mysqli_query($conexion, "SELECT id FROM videojuegos WHERE id = $id_videojuego");
    if (!$check || mysqli_num_rows($check) === 0) {
        $errores[] = "El juego con ID $id_videojuego no existe";
        continue;
    }

    // Verificar que no lo haya comprado ya
    $ya_comprado = mysqli_query($conexion, 
        "SELECT id FROM juegos_comprados WHERE id_comprador = $id_usuario AND id_videojuego = $id_videojuego"
    );
    if ($ya_comprado && mysqli_num_rows($ya_comprado) > 0) {
        $errores[] = "Ya tienes el juego ID $id_videojuego en tu librería";
        continue;
    }

    // Insertar la compra
    $sql = "INSERT INTO juegos_comprados (id_comprador, id_propietario, id_videojuego, fecha_compra) 
            VALUES ($id_usuario, $id_usuario, $id_videojuego, NOW())";
    
    if (mysqli_query($conexion, $sql)) {
        $comprados++;
    } else {
        $errores[] = "Error al comprar juego ID $id_videojuego: " . mysqli_error($conexion);
    }
}

echo json_encode([
    'success' => $comprados > 0,
    'comprados' => $comprados,
    'errores' => $errores,
    'mensaje' => $comprados > 0 
        ? "🎉 ¡$comprados juego(s) comprado(s) exitosamente!" 
        : "No se pudo completar la compra"
]);

$conexion->close();
?>