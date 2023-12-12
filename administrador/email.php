<?php
require 'includes/header.php';
include 'models/dbmatricula.php';
if (isset($_POST['enviar'])) {
require_once 'sendemail.php';
}
$query = "SELECT matricula.*, 
                tipomatricula.descripcion AS tipoMatriculaDescripcion,
                nivel.descripcion AS nivelDescripcion,
                grado.descripcion AS gradoDescripcion
                FROM matricula
            LEFT JOIN tipomatricula ON matricula.idTipoMatricula = tipomatricula.idTipoMatricula
            LEFT JOIN nivel ON matricula.idNivel = nivel.idNivel
            LEFT JOIN grado ON matricula.idGrado = grado.idGrado
            WHERE matricula.estado = 'Aprobado'"; // Agregamos la cláusula WHERE
    $result = $conn->query($query);

?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-speedometer"></i>Envío de confirmación por Email</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
        </ul>
    </div>

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
                <th>Estado de matrícula</th>
                <th>Acciones</th>
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
                echo "<td>" . (isset($row['estado']) ? $row['estado'] : '') . "</td>";
                echo "<td>";
                    echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' style='display:inline;'>";
                    echo "<input type='hidden' name='idMatricula' value='" . $row['idMatricula'] . "'>";                    
                    echo "<button type='submit' class='btn btn-success btn-sm' name='enviar'>Enviar correo</button>";
                    echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</main>