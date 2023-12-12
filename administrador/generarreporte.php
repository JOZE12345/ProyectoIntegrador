<?php
require 'includes/header.php';
include 'models/dbgenerar.php';
?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-speedometer"></i> Bienvenido al proceso de Matricula</h1>
            <p>Seleccione los siguientes datos, para validar disponibilidad: </p>
        </div>

        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="#">Blank Page</a></li>
        </ul>
    </div>

    <div class="row">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <label for="nivel" class="form-label">Seleccione Nivel :</label>
                    <select name="nivel" class="form-select">
                        <?php
                        while ($row = $result_nivel->fetch_assoc()) {
                            echo "<option value='" . $row["idNivel"] . "'>" . $row["descripcion"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="grado" class="form-label">Seleccione Grado:</label>
                    <select name="grado" class="form-select">
                        <?php
                        while ($row = $result_grado->fetch_assoc()) {
                            echo "<option value='" . $row["idGrado"] . "'>" . $row["descripcion"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
            
        </form>

        <?php
         $encontro = false;
         $idNivel = "";
         $idGrado = "";
        // Muestra los resultados debajo del formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") { 
           
            echo "<h2 class='mt-4'>Resultados de la búsqueda:</h2>";
            echo "<table class='table table-bordered'>
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
                <tbody>" ; 

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . (isset($row['idMatricula']) ? $row['idMatricula'] : '') . "</td>";
                    echo "<td>" . (isset($row['nombreAlumno']) ? $row['nombreAlumno'] : '') . "</td>";
                    echo "<td>" . (isset($row['apellidoAlumno']) ? $row['apellidoAlumno'] : '') . "</td>";
                    echo "<td>" . (isset($row['gradoDescripcion']) ? $row['gradoDescripcion'] : '') . "</td>";
                    echo "<td>" . (isset($row['nivelDescripcion']) ? $row['nivelDescripcion'] : '') . "</td>";
                    echo "<td>" . (isset($row['tipoMatriculaDescripcion']) ? $row['tipoMatriculaDescripcion'] : '') . "</td>";
                    echo '<td>';
                    echo "<td>" . (isset($row['estado']) ? $row['estado'] : '') . "</td>";
                    echo "</tr>";
                }

            echo "</tbody></table>";
        }
        ?>

        
    </div>
   
   <br>
   <!-- 

    -->
    
</main>

<?php
require 'includes/footer.php';
?>