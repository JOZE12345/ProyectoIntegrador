<?php
require 'includes/header.php';
include 'models/dbmatricula.php';

if (isset($_GET['idMatricula'])) {
    $idMatricula = $_GET['idMatricula'];

    $query = "SELECT matricula.idMatricula, matricula.idTipoMatricula, matricula.tipoIdentificacion, 
              matricula.numeroDocumento, matricula.nombreAlumno, matricula.apellidoAlumno, 
              matricula.idNivel, matricula.idGrado, matricula.ie_Antigua
              FROM matricula
              WHERE matricula.idMatricula = $idMatricula";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $matriculaData = $result->fetch_assoc();
    } else {
        echo "No se encontraron datos para la matrícula seleccionada.";
        exit();
    }
} else {
    echo "No se proporcionó un ID de matrícula.";
    exit();
}

?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-speedometer"></i>Editar Matrícula</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
        </ul>
    </div>

    <form onsubmit="return validarIEAntigua()" method="post"
            action="models/procesar.php" class="mb-3">
            <input type="hidden" name="idMatricula" value="<?php echo $matriculaData['idMatricula']; ?>">
        <div class="row">
            <div class="col-md-4">
                <label for="idTipoMatricula" class="form-label">ID Tipo Matrícula:</label>
                    <select name="matricula" id="matriculaSelect" class="form-select" required>
                    <?php
                        while ($row = $result_Tipomatricula->fetch_assoc()) {
                            $selected = ($row['idTipoMatricula'] == $matriculaData['idTipoMatricula']) ? 'selected' : '';
                            echo "<option value='" . $row["idTipoMatricula"] . "' $selected>" . $row["descripcion"] . "</option>";
                        }
                        ?>
                    </select>
            </div>
            <div class="col-md-4">
                <label for="tipoIdentificacion" class="form-label">Tipo Identificación:</label>
                <select name="tipo" id="matriculaSelect" class="form-select" required>
                <?php
                    while ($row = $result_tipo->fetch_assoc()) {
                        $selected = ($row['idTipoIdentificacion'] == $matriculaData['tipoIdentificacion']) ? 'selected' : '';
                        echo "<option value='" . $row["idTipoIdentificacion"] . "' $selected>" . $row["descripcion"] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="numeroDocumento" class="form-label">Número Documento:</label>
                <input type="text" name="numeroDocumento" class="form-control" value="<?php echo $matriculaData['numeroDocumento']; ?>">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <label for="nombreAlumno" class="form-label">Nombre del Alumno:</label>
                <input type="text" name="nombreAlumno" class="form-control" value="<?php echo $matriculaData['nombreAlumno']; ?>">
            </div>
            <div class="col-md-4">
                <label for="apellidoAlumno" class="form-label">Apellido del Alumno:</label>
                <input type="text" name="apellidoAlumno" class="form-control" value="<?php echo $matriculaData['apellidoAlumno']; ?>">
            </div>
            <div class="col-md-4" id="bloque_ie_antigua">
                <label for="ieAntigua" class="form-label">Escuela Anterior:</label>
                <input type="text" name="ie_antigua" id="ie_antigua" class="form-control" value="<?php echo $matriculaData['ie_Antigua']; ?>">
                
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <label for="idNivel" class="form-label">ID Nivel:</label>
                <select name="nivel" id="matriculaSelect" class="form-select">
                <?php
                    while ($row = $result_nivel->fetch_assoc()) {
                        $selected = ($row['idNivel'] == $matriculaData['idNivel']) ? 'selected' : '';
                        echo "<option value='" . $row["idNivel"] . "' $selected>" . $row["descripcion"] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="idGrado" class="form-label">ID Grado:</label>
                <select name="grado" id="matriculaSelect" class="form-select">
                    <?php
                        while ($row = $result_grado->fetch_assoc()) {
                            $selected = ($row['idGrado'] == $matriculaData['idGrado']) ? 'selected' : '';
                            echo "<option value='" . $row["idGrado"] . "' $selected>" . $row["descripcion"] . "</option>";
                        }
                        ?>
                </select>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary" name="guardarCambios">Guardar Cambios</button>
            </div>
        </div>
    </form>
    
</main>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Evento change para el select
        $('#matriculaSelect').change(function () {
            var selectedValue = $(this).val();

            $('#ie_antigua').val('');
            if (parseInt(selectedValue) === 1) { // ID Traslado externo
                $("#bloque_ie_antigua").show();
            } else {
                $("#bloque_ie_antigua").hide();
            }

            $.ajax({
                type: 'POST',
                url: 'models/dbmatricula.php', 
                data: { idTipoMatricula: selectedValue == "" ? 0 : selectedValue },
                success: function (response) {                    
                    $('#documentosText').html(response);
                }
            });
        });
    });

    function ocultarInicio() {
        $("#bloque_ie_antigua").hide();
    }

    function validarIEAntigua() {
        var idTipoMat = $('#matriculaSelect').val();
        var textoIe = $('#ie_antigua').val();

        if (parseInt(idTipoMat) === 1) {
            if (textoIe.trim().length == 0) {
                alert('Debe ingresar un nombre de colegio antiguo.');
                return false;
            }
        }
        return true;
    }

    ocultarInicio();
</script>
<?php
require 'includes/footer.php';
?>