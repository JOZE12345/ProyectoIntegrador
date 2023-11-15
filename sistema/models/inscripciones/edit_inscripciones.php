<?php

require_once '../../includes/config.php';

if(!empty($_GET)) {
    $idInscripcion = $_GET['id'];
    //$sql = "SELECT * FROM inscripcion WHERE inscripcion_id = ?";
    $sql = "SELECT * FROM inscripcion as i INNER JOIN alumnos as a ON i.alumno_id = a.alumno_id INNER JOIN curso as c ON i.curso_id = c.curso_id INNER JOIN materia as m ON c.materia_id = m.materia_id INNER JOIN turno as t ON i.turno_id = t.turno_id WHERE i.inscripcion_id = ?";
    $query = $pdo->prepare($sql);
    $query->execute(array($idInscripcion));
    $data = $query->fetch(PDO::FETCH_ASSOC);
    if(empty($data)) {
        $arrResponse = array('status' => false,'msg' => 'Datos no encontrados');
    } else {
        $arrResponse = array('status' => true,'data' => $data);
    }
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}