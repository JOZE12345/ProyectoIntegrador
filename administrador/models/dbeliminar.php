<?php
// Requiere tu archivo de conexión a la base de datos
$conn = require 'conexion.php';

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para eliminar el usuario
    $queryEliminar = "DELETE FROM vacantes WHERE id = ?";
    $stmtE = $conn->prepare($queryEliminar);
    $stmtE->bind_param("i", $id);

    // Ejecutar la consulta
    if ($stmtE->execute()) {
        $mensajeE = 'Usuario eliminado correctamente!';
        echo "<script>alert('$mensajeE');window.location.href='../vacantes.php';</script>";
    } else {
        $mensajeE ='No se ha podido eliminar el usuario' ;
        echo "<script>alert('$mensajeE');window.location.href='../vacantes.php';</script>";
    }

    // Cerrar la consulta preparada
    $stmtE->close();
} else {
    // Manejar el caso en que no se proporcionó un ID válido
    $mensajeE ='ID de usuario no válido' ;
    echo "<script>alert('$mensajeE');window.location.href='../usuarios.php';</script>";
}

// Cerrar la conexión
$conn->close();
?>
