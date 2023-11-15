<?php

require_once '../../includes/config.php';

// CREAR USUARIO
if(!empty($_POST)) {
    if(empty($_POST['txtNombre']) || empty($_POST['txtUsuario']) || empty($_POST['listRol']) || empty($_POST['listStatus'])) {
        $arrResponse = array('status' => false,'msg' => 'Todos los campos son necesarios');
    } else {
        $idUser = $_POST['idUser'];
        $nombre = $_POST['txtNombre'];
        $usuario = $_POST['txtUsuario'];
        $pass = $_POST['clave'];
        $rol = intval($_POST['listRol']);
        $status = intval($_POST['listStatus']);

        $pass = password_hash($pass,PASSWORD_DEFAULT);

        $sql = "SELECT * FROM usuarios WHERE (usuario = ? AND user_id != ?)";
        $query = $pdo->prepare($sql);
        $query->execute(array($usuario,$idUser));
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result > 0) {
            $arrResponse = array('status' => false, 'msg' => 'El usuario ya existe');
        } else {
            if($idUser == 0) {
                $sql_insert = "INSERT INTO usuarios (nombre,usuario,password,rol,estatus) VALUES (?,?,?,?,?)";
                $query_insert = $pdo->prepare($sql_insert);
                $request = $query_insert->execute(array($nombre,$usuario,$pass,$rol,$status));
                $option = 1;    
            } else {
                if(empty($pass)) {
                    $sql_update = "UPDATE usuarios SET nombre = ?,usuario = ?,rol = ?,estatus = ? WHERE user_id = ?";
                    $query_update = $pdo->prepare($sql_update);
                    $request = $query_update->execute(array($nombre,$usuario,$rol,$status,$idUser));
                    $option = 2;
                } else {
                    $sql_update = "UPDATE usuarios SET nombre = ?,usuario = ?, password = ?,rol = ?,estatus = ? WHERE user_id = ?";
                    $query_update = $pdo->prepare($sql_update);
                    $request = $query_update->execute(array($nombre,$usuario,$pass,$rol,$status,$idUser));
                    $option = 3;
                }
                
            }
            if($request > 0) {
                if($option == 1) {
                    $arrResponse = array('status' => true,'msg' => 'Usuario creado correctamente');
                } else {
                    $arrResponse = array('status' => true,'msg' => 'Usuario actualizado correctamente');
                }   
            } 
        }
    }
    
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
    die();

}