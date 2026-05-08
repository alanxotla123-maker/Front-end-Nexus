<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "nexus"; 
$port = "3308"; // Tu puerto configurado

$conexion = mysqli_connect($host, $user, $pass, $db, $port);

if(!$conexion){
    die("Error de conexión: " . mysqli_connect_error());
}

?>
