<?php

require_once '../../includes/config.php';

$sqlAlumno = "SELECT alumno_id,nombre,apellido,estatus FROM alumnos WHERE estatus = 1";
$queryAlumno = $pdo->prepare($sqlAlumno);
$queryAlumno->execute();
$data = $queryAlumno->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data,JSON_UNESCAPED_UNICODE);