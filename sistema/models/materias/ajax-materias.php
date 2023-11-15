<?php

require_once '../../includes/config.php';

if(!empty($_POST)) {
    if(empty($_POST['txtNombre']) || empty($_POST['listStatus'])) {
        $arrResponse = array('status' => false,'msg' => 'Todos los campos son necesarios');
    } else {
        $idMateria = $_POST['idMateria'];
        $nombre = $_POST['txtNombre'];
        $status = $_POST['listStatus'];

        $sql = "SELECT * FROM materia WHERE (nombre_materia = ? AND materia_id != ? AND estatus != 0)";
        $query = $pdo->prepare($sql);
        $query->execute(array($nombre,$idMateria));
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result > 0) {
            $arrResponse = array('status' => false,'msg' => 'Materia ya registrada');
        } else {
            if($idMateria == 0) {
                $sql_insert = "INSERT INTO materia (nombre_materia,estatus) VALUES (?,?)";
                $query_insert = $pdo->prepare($sql_insert);
                $request = $query_insert->execute(array($nombre,$status));
                $option = 1;
            } else {
                $sql_update = "UPDATE materia SET nombre_materia = ?,estatus = ? WHERE materia_id = ?";
                $query_update = $pdo->prepare($sql_update);
                $request = $query_update->execute(array($nombre,$status,$idMateria));
                $option = 2;
            }
            
            if($request > 0) {
                if($option == 1) {
                    $arrResponse = array('status' => true,'msg' => 'Materia creada correctamente');
                } else {
                    $arrResponse = array('status' => true,'msg' => 'Materia actualizada correctamente');
                }
                
            }
        }
    }
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}