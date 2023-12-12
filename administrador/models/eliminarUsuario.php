<?php
// Requiere tu archivo de conexión a la base de datos
$conn = require 'conexion.php';

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idUsuario = $_GET['id'];

    // Consulta para eliminar el usuario
    $queryEliminarUsuario = "DELETE FROM usuarios WHERE idUsuario = ?";
    $stmt = $conn->prepare($queryEliminarUsuario);
    $stmt->bind_param("i", $idUsuario);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $mensaje = 'Usuario eliminado correctamente!';
        echo "<script>alert('$mensaje');window.location.href='../usuarios.php';</script>";
    } else {
        $mensaje ='No se ha podido eliminar el usuario' ;
        echo "<script>alert('$mensaje');window.location.href='../usuarios.php';</script>";
    }

    // Cerrar la consulta preparada
    $stmt->close();
} else {
    // Manejar el caso en que no se proporcionó un ID válido
    $mensaje ='ID de usuario no válido' ;
    echo "<script>alert('$mensaje');window.location.href='../usuarios.php';</script>";
}

// Cerrar la conexión
$conn->close();
?>
