<?php
require 'includes/header.php';
include 'models/dbvacantes.php';
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-speedometer"></i>Bienvenido al formulario de registro de vacantes</h1>
            <p>Proceda a ingresar los datos requeridos</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
        </ul>
    </div>

    <div class="row mt-3">
        <h3 class="text-left">Agregar vacante</h3>
    </div>
        <div class="row">
            <form method="post" action="models/dbVacantes.php" class="mb-3">
                <div class="row">
                <form method="post" action="models/dbVacantes.php" class="mb-3">
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
                            <label for="nombre" class="form-label">Cantidad Vacantes:</label>
                            <input type="text" name="cantidad" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row mt-3">
                <div>
                    <h3 class="text-center">LISTA DE VACANTES REGISTRADAS</h3>
                    <table class="table table-striped table-bordered mt-2">
                        <tr>
                            <td>N°</td>
                            <td>Nivel</td>
                            <td>Grado</td>
                            <td>Cantidad Vacantes </td>
                            <td>Acción</td>
                        </tr>

                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . (isset($row['id']) ? $row['id'] : '') . "</td>";
                            echo "<td>" . (isset($row['descripcion']) ? $row['descripcion'] : '') . "</td>";
                            echo "<td>" . (isset($row['idGrado']) ? $row['idGrado'] : '') . "</td>";
                            echo "<td>" . (isset($row['vacantesDisponibles']) ? $row['vacantesDisponibles'] : '') . "</td>";
                            echo "<td><a href='models/dbeliminar.php?id=" . (isset($row['id']) ? $row['id'] : '') . "'>Eliminar</a></td>";
                                    
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </form>
    </div>
</main>
<?php
require 'includes/footer.php';
?>