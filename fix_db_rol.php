<?php
include("Conexion/conexion.php");

// Intentar agregar la columna 'rol' si no existe
$sql = "ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS rol VARCHAR(50) DEFAULT 'usuario'";
if (mysqli_query($conexion, $sql)) {
    echo "Columna 'rol' verificada/creada correctamente.\n";
} else {
    // Si IF NOT EXISTS no es soportado por la versión de MySQL, intentamos de otra forma
    $check = mysqli_query($conexion, "SHOW COLUMNS FROM usuarios LIKE 'rol'");
    if (mysqli_num_rows($check) == 0) {
        if (mysqli_query($conexion, "ALTER TABLE usuarios ADD rol VARCHAR(50) DEFAULT 'usuario'")) {
            echo "Columna 'rol' creada correctamente.\n";
        } else {
            echo "Error al crear la columna 'rol': " . mysqli_error($conexion) . "\n";
        }
    } else {
        echo "La columna 'rol' ya existe.\n";
    }
}

mysqli_close($conexion);
?>
