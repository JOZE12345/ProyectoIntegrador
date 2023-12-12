<?php
$conn = require 'conexion.php';

if (!isset($_SESSION)) {
    session_start();
}

// Obtén datos para los combo boxes
$query_matricula = "SELECT idTipoMatricula, descripcion FROM tipomatricula";
$result_matricula = $conn->query($query_matricula);

// Obtén datos para los combo boxes
$query_tipo = "SELECT idTipoIdentificacion, descripcion FROM tipoidentificacion";
$result_tipo = $conn->query($query_tipo);

$query_nivel = "SELECT idNivel, descripcion FROM nivel";
$result_nivel = $conn->query($query_nivel);

$query_grado = "SELECT idGrado, descripcion FROM grado";
$result_grado = $conn->query($query_grado);

$query_matricula = "SELECT idMatricula, nombreAlumno FROM matricula";
$result_matricula = $conn->query($query_matricula);

$query_Tipomatricula = "select idTipoMatricula,descripcion from tipomatricula";
$result_Tipomatricula = $conn->query($query_Tipomatricula);

// Verificar si se recibió el parámetro esperado
if (isset($_POST['idTipoMatricula'])) {
    // Obtener el valor seleccionado
    $idTipoMatricula = $_POST['idTipoMatricula'];

    // Realizar la consulta a la base de datos para obtener los documentos asociados a $idTipoMatricula
    $sql = "SELECT contenido FROM tipomatricula WHERE idTipoMatricula = $idTipoMatricula";
    $result = $conn->query($sql);  // Cambié $mysqli por $conn

    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        // Construir el contenido HTML de los documentos
        $documentosHTML = "<ul>";
        while ($row = $result->fetch_assoc()) {
            $documentosHTML .= "<li>" . $row['contenido'] . "</li>"; // Reemplaza 'contenido' con el nombre del campo en tu tabla
        }
        $documentosHTML .= "</ul>";

        // Devolver el contenido HTML
        echo $documentosHTML;
    } else {
        // Si no hay resultados, puedes devolver un mensaje indicando que no hay documentos
        echo "No hay documentos disponibles para esta opción de matrícula.";
    }
}

// Guardar MATRICULA

if (isset($_POST['guardarMatricula'])) {
    $ruta_archivo = '../archivos/matriculas';
    $tiempo =  round( microtime(true));

    // recuperando datos
    $nombre_archivo = $tiempo.$_FILES['fileInput']['name'];
    $idTipoMatricula = $_REQUEST['matricula'];
    $tipoIdentificacion = $_REQUEST['tipo']; 
    $NroIdentificacion = $_REQUEST['identificacion'];
    $ieAntigua = $_REQUEST['ie_antigua'];  
    $nombres = $_REQUEST['nombres']; 
    $napellidos = $_REQUEST['apellidos']; 
    $idNivel = $_SESSION['idNivel'] ;
    $idGrado = $_SESSION['idGrado'] ;
    $idUsuario = $_SESSION['id_usuario'];

    $sql = "CALL SP_GUARDAR_MATRICULA('$idTipoMatricula','$ieAntigua','$nombre_archivo',
    '$tipoIdentificacion','$NroIdentificacion','$nombres','$napellidos','$idNivel','$idGrado','$idUsuario')";

    $result = $conn->query($sql);

    /*
    echo "ID_TIPO MATRICULA: ".  $idTipoMatricula;
    echo "<br>archivo: ".   $nombre_archivo;
    echo "<br>tipoIdentificacion: ".  $tipoIdentificacion;
    echo "<br>NroIdentificacion: ".  $NroIdentificacion;
    echo "<br>ieAntigua: ".  $ieAntigua;
    echo "<br>napellidos: ".  $napellidos;
    echo "<br>idNivel: ".  $idNivel;
    echo "<br>nombres: ".  $nombres;
    echo "<br>idGrado: ".  $idGrado;
    echo "<br>resultado: ".  $result;
    echo "<br>sql: ".  $sql;
    */
    if($result){
        if (!file_exists($ruta_archivo)) {
            mkdir($ruta_archivo, 0777, true); 
        }
    
        $carpeta_destino = $ruta_archivo.'/' . $nombre_archivo;
        move_uploaded_file($_FILES['fileInput']['tmp_name'], $carpeta_destino);

        $mensaje = 'Matricula registrada de forma correcta!';
        echo "<script>alert('$mensaje');window.location.href='../usuario/aviso.php'</script>";
    }else{
        $mensaje ='No se ha podido registrar matricula' ;
        echo "<script>alert('$mensaje');window.location.href='../usuario/matricula.php'</script>";
    }

    
}
?>