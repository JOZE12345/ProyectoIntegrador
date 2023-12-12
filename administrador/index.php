<?php
require 'includes/header.php';
include 'models/dbprocesados.php';
include 'models/dbmatricula.php';

// Procesar formularios
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['buscar'])) {
        $busqueda = $_POST['buscar'];
        // Modifica tu consulta para incluir la condición de búsqueda
        $query = "SELECT matricula.*, 
                         tipomatricula.descripcion AS tipoMatriculaDescripcion,
                         nivel.descripcion AS nivelDescripcion,
                         grado.descripcion AS gradoDescripcion
                  FROM matricula
                  LEFT JOIN tipomatricula ON matricula.idTipoMatricula = tipomatricula.idTipoMatricula
                  LEFT JOIN nivel ON matricula.idNivel = nivel.idNivel
                  LEFT JOIN grado ON matricula.idGrado = grado.idGrado
                  WHERE matricula.idMatricula LIKE '%$busqueda%'
                  OR matricula.nombreAlumno LIKE '%$busqueda%'
                  OR matricula.apellidoAlumno LIKE '%$busqueda%'
                  OR CONCAT(matricula.nombreAlumno, ' ', matricula.apellidoAlumno) LIKE '%$busqueda%'
                  OR grado.descripcion LIKE '%$busqueda%'
                  OR nivel.descripcion LIKE '%$busqueda%'
                  OR matricula.archivoVaucher LIKE '%$busqueda%'
                  OR tipomatricula.descripcion LIKE '%$busqueda%'
                  OR matricula.archivoDocumentacion LIKE '%$busqueda%'
                  OR matricula.estado LIKE '%$busqueda%'";
        $result = $conn->query($query);
    } elseif (isset($_POST['editar'])) {
        // Obtén el ID de la matrícula a editar
        $idMatricula = $_POST['idMatricula'];
        
        // Redirige a la página de editar.php con el ID de la matrícula como parámetro
        header("Location: editar.php?idMatricula=$idMatricula");
        exit();
    } elseif (isset($_POST['expulsar'])) {
        // Procesar formulario de Expulsar
        $idMatricula = $_POST['idMatricula'];
        // Realiza la lógica necesaria para cambiar el estado a "Expulsado" en la base de datos
        $query = "UPDATE matricula SET estado = 'Expulsado' WHERE idMatricula = $idMatricula";
        $conn->query($query);

        // Redirige a la misma página después de la actualización
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } elseif (isset($_POST['aprobar'])) {
        // Procesar formulario de Aprobar
        $idMatricula = $_POST['idMatricula'];
        // Realiza la lógica necesaria para cambiar el estado a "Aprobado" en la base de datos
        $query = "UPDATE matricula SET estado = 'Aprobado' WHERE idMatricula = $idMatricula";
        $conn->query($query);

        // Redirige a la misma página después de la actualización
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
} else {
    // Si no se ha enviado un formulario de búsqueda, simplemente obtén todos los registros
    $query = "SELECT matricula.*, 
                     tipomatricula.descripcion AS tipoMatriculaDescripcion,
                     nivel.descripcion AS nivelDescripcion,
                     grado.descripcion AS gradoDescripcion
              FROM matricula
              LEFT JOIN tipomatricula ON matricula.idTipoMatricula = tipomatricula.idTipoMatricula
              LEFT JOIN nivel ON matricula.idNivel = nivel.idNivel
              LEFT JOIN grado ON matricula.idGrado = grado.idGrado";
    $result = $conn->query($query);
}


?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-speedometer"></i>Busqueda</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
        </ul>
    </div>
       
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <label for="buscar" class="form-label">Buscar:</label>
                <input type="text" name="buscar" class="form-control" placeholder="Ingrese el dato">
                <br><button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </div>
    </form>


    <div class="row mt-3">
    <table class="table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Grado</th>
                <th>Nivel</th>
                <th>Tipo Matrícula</th>
                <th>Voucher</th>
                <th>Documentos</th>
                <th>Acciones</th>
                <th>Estado de matrícula</th>
            </tr>
        </thead>
        <tbody>
            <!-- tabla generada dinámicamente -->
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . (isset($row['idMatricula']) ? $row['idMatricula'] : '') . "</td>";
                echo "<td>" . (isset($row['nombreAlumno']) ? $row['nombreAlumno'] : '') . "</td>";
                echo "<td>" . (isset($row['apellidoAlumno']) ? $row['apellidoAlumno'] : '') . "</td>";
                echo "<td>" . (isset($row['gradoDescripcion']) ? $row['gradoDescripcion'] : '') . "</td>";
                echo "<td>" . (isset($row['nivelDescripcion']) ? $row['nivelDescripcion'] : '') . "</td>";
                echo "<td>" . (isset($row['tipoMatriculaDescripcion']) ? $row['tipoMatriculaDescripcion'] : '') . "</td>";
                echo '<td>';
                if (!empty($row['archivoVaucher'])) {
                    echo '<a href="../archivos/vaucher/' . $row['archivoVaucher'] . '" target="_blank" class="btn btn-danger btn-sm" title="Ver archivo adjunto"><i class="fa fa-file-pdf"></i></a>';
                }
                echo '</td>';
                echo '<td>';
                if (!empty($row['archivoDocumentacion'])) {
                    echo '<a href="../archivos/matriculas/' . $row['archivoDocumentacion'] . '" target="_blank" class="btn btn-primary btn-sm" title="Ver archivo de documentación"><i class="fa fa-file-pdf"></i></a>';
                }
                echo '</td>';
                echo "<td>";
                    echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' style='display:inline;'>";
                    echo "<input type='hidden' name='idMatricula' value='" . $row['idMatricula'] . "'>";
                    echo "<button type='submit' class='btn btn-warning btn-sm' name='editar'>Editar</button>";
                    
                    echo "<button type='submit' class='btn btn-danger btn-sm' name='expulsar'>Rechazar</button>";
                    
                    echo "<button type='submit' class='btn btn-success btn-sm' name='aprobar'>Aprobar</button>";
                    echo "</form>";
                echo "</td>";
                echo "<td>" . (isset($row['estado']) ? $row['estado'] : '') . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

    <div class="row mt-3">
        <div class="col-md-12">
            <a href="reportepdf.php"  class="btn btn-primary">Reporte de Matriculados</a>
        </div>
    </div>

</main>


<?php
require 'includes/footer.php';
?>
