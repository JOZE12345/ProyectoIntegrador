<?php
require_once '../../includes/config.php';

// OPCION PARA MATERIA
//$htmlOption = "";
$sqlConsultaMateria = "SELECT materia_id,nombre_materia FROM materia WHERE estatus = 1";
$queryConsultaMateria = $pdo->prepare($sqlConsultaMateria);
$queryConsultaMateria->execute();
$data = $queryConsultaMateria->fetchAll(PDO::FETCH_ASSOC);

/*
if(count($data) > 0) {
    for($i = 0;$i < count($data);$i++) {
        $htmlOption .= '<option value="'.$data[$i]['materia_id'].'">'.$data[$i]['nombre_materia'].'</option>';
    }
}
echo $htmlOption;
*/
echo json_encode($data,JSON_UNESCAPED_UNICODE);

?>