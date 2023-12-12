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
?>