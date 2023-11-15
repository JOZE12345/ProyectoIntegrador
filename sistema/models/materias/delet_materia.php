<?php

require_once '../../includes/config.php';

if($_POST) {
    $idMateria = $_POST['idMateria'];

    $sql_materia = "SELECT * FROM curso WHERE materia_id = $idMateria AND estatusC != 0";
    $query_materia = $pdo->prepare($sql_materia);
    $query_materia->execute();
    $result_materia = $query_materia->fetchAll(PDO::FETCH_ASSOC);

    if(empty($result_materia)) {
        $sql = "UPDATE materia SET estatus = 0 WHERE materia_id = ?";
        $query = $pdo->prepare($sql);
        $result = $query->execute(array($idMateria));

        if($result) {
            $arrResponse = array('status' => true,'msg' => 'Eliminado correctamente');
        } else {
            $arrResponse = array('status' => false,'msg' => 'Error al eliminar');
        }
    } else {
        $arrResponse = array('status' => false,'msg' => 'No se puede eliminar una materia asociada a un curso');
    }    
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}
