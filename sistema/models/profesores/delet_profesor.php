<?php

require_once '../../includes/config.php';

if($_POST) {
    $idProfesor = $_POST['idProfesor'];

    $sql_profesor = "SELECT * FROM curso WHERE profesor_id = $idProfesor AND estatusC != 0";
    $query_profesor = $pdo->prepare($sql_profesor);
    $query_profesor->execute();
    $result_profesor = $query_profesor->fetchAll(PDO::FETCH_ASSOC);

    if(empty($result_profesor)) {
        $sql = "UPDATE profesor SET estatus = 0 WHERE profesor_id = ?";
        $query = $pdo->prepare($sql);
        $result = $query->execute(array($idProfesor));

        if($result) {
            $arrResponse = array('status' => true,'msg' => 'Eliminado correctamente');
        } else {
            $arrResponse = array('status' => false,'msg' => 'Error al eliminar');
        }
    } else {
        $arrResponse = array('status' => false,'msg' => 'No se puede eliminar a un profesor asociado a un curso');
    }

    
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}