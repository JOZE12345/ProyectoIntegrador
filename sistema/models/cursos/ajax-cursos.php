<?php

require_once '../../includes/config.php';

if(!empty($_POST)) {
    if(empty($_POST['listMateria']) || empty($_POST['listProfesor']) || empty($_POST['listStatus'])) {
        $arrResponse = array('status' => false,'msg' => 'Todos los campos son necesarios');
    } else {
        $idCurso = $_POST['idCurso'];
        $materia = $_POST['listMateria'];
        $profesor = $_POST['listProfesor'];
        $status = $_POST['listStatus'];

        // CONSULTA PARA INSERTAR
        $sql = "SELECT * FROM curso WHERE materia_id = ? AND profesor_id = ? AND estatusC != 0";
        $query = $pdo->prepare($sql);
        $query->execute(array($materia,$profesor));
        $resultInsert = $query->fetch(PDO::FETCH_ASSOC);
        
        // CONSULTA PARA ACTUALIZAR
        $sql2 = "SELECT * FROM curso WHERE materia_id = ? AND profesor_id = ? AND estatusC != 0 AND curso_id != ?";
        $query2 = $pdo->prepare($sql2);
        $query2->execute(array($materia,$profesor,$idCurso));
        $resultUpdate = $query2->fetch(PDO::FETCH_ASSOC);

        if($resultInsert > 0) {
            $arrResponse = array('status' => false,'msg' => 'La materia y el profesor ya existen, seleccione otro');
        } else {
            if($idCurso == 0) {
                $sql_insert = "INSERT INTO curso (materia_id,profesor_id,estatusC) VALUES (?,?,?)";
                $query_insert = $pdo->prepare($sql_insert);
                $request = $query_insert->execute(array($materia,$profesor,$status));
                if($request) {
                    $arrResponse = array('status' => true,'msg' => 'Curso creado correctamente'); 
                }
            }  
        }
        if($resultUpdate > 0) {
            $arrResponse = array('status' => false,'msg' => 'La materia y el profesor ya existen, seleccione otro');
        } else {
            if($idCurso > 0) {
                $sql_update = "UPDATE curso SET materia_id = ?,profesor_id = ?,estatusC = ? WHERE curso_id = ?";
                $query_update = $pdo->prepare($sql_update);
                $request2 = $query_update->execute(array($materia,$profesor,$status,$idCurso));
                if($request2) {
                    $arrResponse = array('status' => true,'msg' => 'Curso actualizado correctamente');
                }
             }
        }
    }
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
}