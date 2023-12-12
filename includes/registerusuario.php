<?php
require 'conexion.php';

// Consulta SQL para obtener los datos de la tabla
$sql_iden = "SELECT idTipoIdentificacion, descripcion FROM tipoidentificacion";
$result_tipo = $conn->query($sql_iden);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recuperar los datos del formulario
    $tipoIdentificacion = $_POST['tipo'];
    $identificacion = $_POST['identificacion'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $sexo = ($_POST['sexo'] == 'M') ? 'M' : 'F'; // Asignar 'M' si es masculino, 'F' si es femenino
    $contrasena = ($_POST['contrasena']); // Hash de la contraseña
    $idTipoUsuario = 2; // Siempre 2 según los requisitos

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
        echo "<script>alert('$mensaje');window.location.href='../index.php';</script>";
    } else {
        $mensaje ='No se ha podido registrar el usuario' ;
        echo "<script>alert('$mensaje');window.location.href='../register.php';</script>";
    }

    // Cerrar la consulta preparada
    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>