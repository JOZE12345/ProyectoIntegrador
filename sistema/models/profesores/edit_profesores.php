<?php

require_once '../../includes/config.php';

$idProfesor = $_GET['id'];
$sql = "SELECT * FROM profesor WHERE profesor_id = ?";
$query = $pdo->prepare($sql);
$query->execute(array($idProfesor));
$data = $query->fetch(PDO::FETCH_ASSOC);

if(empty($data)) {
    $arrResponse = array('status' => false,'msg' => 'Datos no encontrados');
} else {
    $arrResponse = array('status' => true,'data' => $data);
}
echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);