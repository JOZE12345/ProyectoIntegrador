<?php
ob_start();
include 'models/conexion.php';

$query = "SELECT matricula.*, 
                 tipomatricula.descripcion AS tipoMatriculaDescripcion,
                 nivel.descripcion AS nivelDescripcion,
                 grado.descripcion AS gradoDescripcion
          FROM matricula
          LEFT JOIN tipomatricula ON matricula.idTipoMatricula = tipomatricula.idTipoMatricula
          LEFT JOIN nivel ON matricula.idNivel = nivel.idNivel
          LEFT JOIN grado ON matricula.idGrado = grado.idGrado";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Estilos para la tabla */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Estilos para las celdas */
        .table th,
        .table td {
            border-bottom: 1px solid #ddd;
            padding: 8px;
        }

        /* Estilos para los encabezados */
        .table th {
            font-weight: bold;
            text-align: left;
        }

        /* Estilos para los enlaces dentro de las celdas de datos */
        .table a {
            color: #0066cc;
            text-decoration: none;
        }

        .table a:hover {
            text-decoration: underline;
            color: #004080;
        }
    </style>
</head>
<body>
<table class="table" id="dataTable">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Grado</th>
                <th>Nivel</th>
                <th>Tipo Matrícula</th>
                <th>Estado de Matricula</th>
            </tr>
        </thead>
        <tbody>
        <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . (isset($row['idMatricula']) ? $row['idMatricula'] : '') . "</td>";
                echo "<td>" . (isset($row['nombreAlumno']) ? $row['nombreAlumno'] : '') . "</td>";
                echo "<td>" . (isset($row['apellidoAlumno']) ? $row['apellidoAlumno'] : '') . "</td>";
                echo "<td>" . (isset($row['gradoDescripcion']) ? $row['gradoDescripcion'] : '') . "</td>";
                echo "<td>" . (isset($row['nivelDescripcion']) ? $row['nivelDescripcion'] : '') . "</td>";
                echo "<td>" . (isset($row['tipoMatriculaDescripcion']) ? $row['tipoMatriculaDescripcion'] : '') . "</td>";
                echo "<td>" . (isset($row['estado']) ? $row['estado'] : '') . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
    $html = ob_get_clean();
    //echo $html;
    require_once 'libreria/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();

    $options = $dompdf->getOptions();
    $options->set(array('isRemoteEnabled' => true));
    $dompdf->setOptions($options);

    $dompdf->loadHtml($html);

    $dompdf->setPaper('letter');

    $dompdf->render();
    $dompdf->stream("ReporteMatricula.pdf", array("Attachment" => false));

?>