<?php

require_once '../../includes/config.php';

$sql = "SELECT * FROM inscripcion as i INNER JOIN alumnos as a ON i.alumno_id = a.alumno_id INNER JOIN curso as c ON i.curso_id = c.curso_id INNER JOIN materia as m ON c.materia_id = m.materia_id INNER JOIN turno as t ON i.turno_id = t.turno_id WHERE i.estatusI != 0";
$query = $pdo->prepare($sql);
$query->execute();
$data = $query->fetchAll(PDO::FETCH_ASSOC);

for($i = 0;$i < count($data);$i++) {
    if($data[$i]['estatusI'] == 1) {
        $data[$i]['estatusI'] = '<span class="badge badge-success">Activo</span>';
    } else {
        $data[$i]['estatusI'] = '<span class="badge badge-danger">Inactivo</span>';
    }

    $data[$i]['options'] = '<div class="text-center">
            <button class="btn btn-primary btn-sm btnEditInscripcion" rl="'.$data[$i]['inscripcion_id'].'" title="Editar"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn btn-danger btn-sm btnDelInscripcion" rl="'.$data[$i]['inscripcion_id'].'" title="Eliminar"><i class="fas fa-trash-alt"></i></button>                   
                           </div>';
}
echo json_encode($data,JSON_UNESCAPED_UNICODE);
die();



// SELECT COUNT(alumno_id) AS cantidad, curso_id FROM inscripcion GROUP BY curso_id
