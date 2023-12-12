<?php
$conn = require 'conexion.php';

// Obtén datos para los combo boxes
$query_nivel = "SELECT idNivel, descripcion FROM nivel";
$result_nivel = $conn->query($query_nivel);

$query_grado = "SELECT idGrado, descripcion FROM grado";
$result_grado = $conn->query($query_grado);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedNivel = $_POST["nivel"];
    $selectedGrado = $_POST["grado"];

    $query_busqueda = "SELECT n.descripcion, v.idGrado, v.vacantesDisponibles FROM vacantes v INNER JOIN nivel n on n.idNivel = v.idNivel WHERE n.idNivel= $selectedNivel AND v.idGrado = $selectedGrado ";
    $result_busqueda = $conn->query($query_busqueda);
}

$query = "SELECT v.id ,n.descripcion, v.idGrado, v.vacantesDisponibles FROM vacantes v INNER JOIN nivel n on n.idNivel = v.idNivel";
$result = $conn->query($query);

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $idNivel = $_POST['nivel'];
    $idGrado = $_POST['grado'];
    $vacantesdisponibles = $_POST['cantidad'];

    // Consulta SQL parametrizada para insertar un nuevo usuario
    $stmt = $conn->prepare("INSERT INTO vacantes (idNivel, idGrado, vacantesDisponibles)VALUES (?, ?, ?)");
    $stmt->bind_param("iii",$idNivel, $idGrado, $vacantesdisponibles);

 
    // Ejecutar la consulta
    $result = $stmt->execute();

    // Verificar el resultado
    if ($result) {
        $mensaje = 'Vacante registrada correctamente!';
        echo "<script>alert('$mensaje');window.location.href='../vacantes.php';</script>";
    } else {
        $mensaje ='No se puede registrar vacante' ;
        echo "<script>alert('$mensaje');window.location.href='../vacantes.php';</script>";
    }

    // Cerrar la consulta preparada
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $id = $_POST['id'];

    $stmtEliminar = $conn->prepare("DELETE FROM vacantes WHERE id = ?");
    $stmtEliminar->bind_param("i", $id);

    // Ejecutar la consulta
    $resultadoEliminar = $stmtEliminar->execute();

    // Verificar el resultado
    if ($resultadoEliminar) {
        $mensajeEliminar = 'Vacante registrada correctamente!';
        echo "<script>alert('$mensajeEliminar');window.location.href='../vacantes.php';</script>";
    } else {
        $mensajeEliminar ='No se puede registrar vacante' ;
        echo "<script>alert('$mensajeEliminar');window.location.href='../vacantes.php';</script>";
    }

    // Cerrar la consulta preparada
    $stmtEliminar->close();
}



?>