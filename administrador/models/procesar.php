<?php
include 'dbmatricula.php';
$conn = require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['idMatricula'])) {
        $idMatricula = $_POST['idMatricula'];

        $idTipoMatricula = $_POST['matricula'];
        $tipoIdentificacion = $_POST['tipo'];
        $numeroDocumento = $_POST['numeroDocumento'];
        $nombreAlumno = $_POST['nombreAlumno'];
        $apellidoAlumno = $_POST['apellidoAlumno'];
        $ieAntigua = $_POST['ie_antigua'];
        $idNivel = $_POST['nivel'];
        $idGrado = $_POST['grado'];

        $query = "UPDATE matricula SET
                  idTipoMatricula = ?,
                  tipoIdentificacion = ?,
                  numeroDocumento = ?,
                  nombreAlumno = ?,
                  apellidoAlumno = ?,
                  ie_Antigua = ?,
                  idNivel = ?,
                  idGrado = ?
                  WHERE idMatricula = ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("isssssiii", $idTipoMatricula, $tipoIdentificacion, $numeroDocumento, $nombreAlumno, $apellidoAlumno, $ieAntigua, $idNivel, $idGrado, $idMatricula);
        
        if ($stmt->execute()) {
            $mensaje = 'Se ctualizaron los datos correctamente';
        echo "<script>alert('$mensaje');window.location.href='../editar.php?idMatricula=$idMatricula'</script>";;
        } else {
            echo "Error al actualizar los datos: " . $stmt->error;
        }
    } else {
        echo "No se proporcionó un ID de matrícula.";
    }
} else {
    echo "La solicitud no es un POST.";
}
?>
?>