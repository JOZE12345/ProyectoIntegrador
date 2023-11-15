<?php

require_once '../../includes/config.php';

$sql = "SELECT * FROM alumnos WHERE estatus != 0";
$query = $pdo->prepare($sql);
$query->execute();
$data = $query->fetchAll(PDO::FETCH_ASSOC);

for($i = 0;$i < count($data);$i++) {
    if($data[$i]['estatus'] == 1) {
        $data[$i]['estatus'] = '<span class="badge badge-success">Activo</span>';
    } else {
        $data[$i]['estatus'] = '<span class="badge badge-danger">Inactivo</span>';
    }

    $data[$i]['options'] = '<div class="text-center">
    <button class="btn btn-primary btn-sm btnEditAlumno" rl="'.$data[$i]['alumno_id'].'" title="Editar"><i class="fas fa-pencil-alt"></i></button>
    <button class="btn btn-danger btn-sm btnDelAlumno" rl="'.$data[$i]['alumno_id'].'" title="Eliminar"><i class="fas fa-trash-alt"></i></button>                   
                           </div>';
}

echo json_encode($data,JSON_UNESCAPED_UNICODE);
die();