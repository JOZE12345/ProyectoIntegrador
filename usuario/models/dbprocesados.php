<?php
$conn = require 'conexion.php';

if (!isset($_SESSION)) {
    session_start();
}

$idUsuario = $_SESSION['id_usuario'];

$result_procesados = $conn->query("SELECT * FROM matricula WHERE idusuario='$idUsuario'");



if (isset($_POST['guardarVaucher'])) {
    $ruta_archivo = '../archivos/vaucher';

    // recuperando datos
    $idMatricula = $_REQUEST['idMatricula'];
    $nombre_archivo = $idMatricula.'_'.$_FILES['fileInput']['name'];
   

    $sql = "UPDATE matricula SET archivoVaucher = '$nombre_archivo' WHERE idMatricula='$idMatricula'";
    $result = $conn->query($sql);

    if($result){
        if (!file_exists($ruta_archivo)) {
            mkdir($ruta_archivo, 0777, true); 
        }
    
        $carpeta_destino = $ruta_archivo.'/' . $nombre_archivo;
        move_uploaded_file($_FILES['fileInput']['tmp_name'], $carpeta_destino);

        $mensaje = 'Se adjuntó de forma correcta el voucher!';
        echo "<script>alert('$mensaje');window.location.href='../usuario/detalle.php'</script>";
    }else{
        $mensaje ='No se ha podido guardar voucher' ;
        echo "<script>alert('$mensaje');window.location.href='../usuario/detalle.php'</script>";
    }
}

?>