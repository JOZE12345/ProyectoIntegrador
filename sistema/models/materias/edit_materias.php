<?php

require_once '../../includes/config.php';

if(!empty($_GET)) {
    $idMateria = $_GET['id'];
    $sql = "SELECT * FROM materia WHERE materia_id = ?";
    $query = $pdo->prepare($sql);
    $query->execute(array($idMateria));
    $data = $query->fetch(PDO::FETCH_ASSOC);

    if(empty($data)) {
        $arrResponse = array('status' => false,'msg' => 'Datos no encontrados');
    } else {
        $arrResponse = array('status' => true,'data' => $data);
    }
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}