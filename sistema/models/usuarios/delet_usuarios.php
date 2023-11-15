<?php

require_once '../../includes/config.php';

if($_POST) {
    $idUser = $_POST['idUser'];
    $sql = "UPDATE usuarios SET estatus = 0 WHERE user_id = ?";
    $query = $pdo->prepare($sql);
    $result = $query->execute(array($idUser));
    if($result) {
        $arrResponse = array('status' => true,'msg' => 'Eliminado correctamente');
    } else {
        $arrResponse = array('status' => false,'msg' => 'Problema al eliminar');
    }
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}