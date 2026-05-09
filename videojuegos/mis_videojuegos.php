<?php
session_start();
include("../Conexion/conexion.php");
header('Content-Type: application/json');

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql= "SELECT * FROM juegos_comprados WHERE id_usuario = $id " ;
    $resultado = mysqli_query($conexion, $sql);
    $videojuegos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

    echo json_encode($videojuegos);

}



?>