<?php
$conn = require 'conexion.php';

if (!isset($_SESSION)) {
    session_start();
}

// Obtén datos para los combo boxes
$query_tipo_documento = "SELECT idTipoIdentificacion, descripcion FROM tipoidentificacion";
$result_tipo_documento = $conn->query($query_tipo_documento);

// Consulta para obtener la lista de usuarios registrados
$query_lista_usuarios = "SELECT * FROM usuarios";
$result_lista_usuarios = $conn->query($query_lista_usuarios);

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $tipoIdentificacion = $_POST['tipo'];
    $identificacion = $_POST['identificacion'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $sexo = ($_POST['sexo'] == 'M') ? 'M' : 'F'; // Asignar 'M' si es masculino, 'F' si es femenino
    $contrasena = ($_POST['contrasena']); // Hash de la contraseña
    $idTipoUsuario = 1; // Según los requisitos

    // Obtener el último idUsuario registrado
    $result = $conn->query("SELECT MAX(idUsuario) as maxId FROM usuarios");
    $row = $result->fetch_assoc();
    $ultimoIdUsuario = ($row['maxId'] !== null) ? $row['maxId'] + 1 : 1;

    // Consulta SQL parametrizada para insertar un nuevo usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (idUsuario, identificacion, nombre, apellido, email, sexo, contraseña, idTipoUsuario, idTipoIdentificacion) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissssssi", $ultimoIdUsuario, $identificacion, $nombre, $apellido, $email, $sexo, $contrasena, $idTipoUsuario, $tipoIdentificacion);

 
    // Ejecutar la consulta
    $result = $stmt->execute();

    // Verificar el resultado
    if ($result) {
        $mensaje = 'Usuario registrado correctamente!';
        echo "<script>alert('$mensaje');window.location.href='../usuarios.php';</script>";
    } else {
        $mensaje ='No se ha podido registrar el usuario' ;
        echo "<script>alert('$mensaje');window.location.href='../usuarios.php';</script>";
    }

    // Cerrar la consulta preparada
    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>
