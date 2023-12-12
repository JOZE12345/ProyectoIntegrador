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

    $query_busqueda = "SELECT matricula.*, 
    tipomatricula.descripcion AS tipoMatriculaDescripcion,
    nivel.descripcion AS nivelDescripcion,
    grado.descripcion AS gradoDescripcion
    FROM matricula
    LEFT JOIN tipomatricula ON matricula.idTipoMatricula = tipomatricula.idTipoMatricula
    LEFT JOIN nivel ON matricula.idNivel = $selectedNivel
    LEFT JOIN grado ON matricula.idGrado = $selectedGrado"; 

    $result_busqueda = $conn->query($query_busqueda);
}
?>