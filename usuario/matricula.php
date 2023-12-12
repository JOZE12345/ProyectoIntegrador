<?php
require 'includes/header.php';
include 'models/dbmatricula.php';

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
}

$idGrado = 0;
$idNivel = 0;
if (isset($_SESSION['idNivel']) && isset($_SESSION['idGrado'])) {
    $idNivel = $_SESSION['idNivel'];
    $idGrado = $_SESSION['idGrado'];
} else {
    header('location:index.php');
}
?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-speedometer"></i> Bienvenido al proceso de Matricula</h1>
            <p>Proceda con el ingreso de los datos solcitados: </p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="#">Blank Page</a></li>
        </ul>
    </div>
    <div class="row">
        <form onsubmit="return validarIEAntigua()" method="post"
            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <label for="matricula" class="form-label">Seleccione Tipo Matricula :</label>
                    <select name="matricula" id="matriculaSelect" class="form-select" required>
                        <option value="">::: Seleccione :::</option>
                        <?php
                        while ($row = $result_Tipomatricula->fetch_assoc()) {
                            echo "<option value='" . $row["idTipoMatricula"] . "'>" . $row["descripcion"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-9">
                    <label for="matricula" class="form-label">Documentos a entregar :</label>
                    <div class="card text-white bg-dark mb-3">
                        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                            <p class="card-text mb-1" id="documentosText">Selecciona un tipo de matrícula para ver los
                                documentos.</p>
                        </div>
                    </div>


                </div>
            </div>
    </div>

    <div class="row">
        <div class="form-group row col-md-6 " id="bloque_ie_antigua">
            <label for="staticEmail" class="col-sm-4 col-form-label">Colegio Anterior:</label>
            <div class="col-sm-8">
                <input type="text" name="ie_antigua" id="ie_antigua" class="form-control">
            </div>
        </div>


        <div class="col-md-6">
            <label for="fileInput" class="form-label">Cargar archivos PDF: </label>
            <input type="file" name="fileInput" id="fileInput" multiple accept=".pdf" class="form-control-file"
                required="">
        </div>
    </div>
    <hr />
    <h3>Datos del estudiante</h3>
    <div class="row">
        <div class="col-md-6">

            <div class="form-group">
                <label for="tipo" class="form-label">Tipo Identificacion:</label>
                <select name="tipo" id="matriculaSelect" class="form-select" required>
                    <?php
                    while ($row = $result_tipo->fetch_assoc()) {

                        echo "<option value='" . $row["idTipoIdentificacion"] . "'>" . $row["descripcion"] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nombres">Ingresa Nombres:</label>
                <input type="text" class="form-control" id="nombres" name="nombres" required>
            </div>
            <!-- Combo con nivel -->
            <div class="form-group">
                <label for="nivel" class="form-label">Seleccione Nivel:</label>
                <select name="nivel" id="matriculaSelect" class="form-select" disabled>
                    <?php
                    while ($row = $result_nivel->fetch_assoc()) {
                        if ($idNivel == $row["idNivel"]) {
                            echo "<option value='" . $row["idNivel"] . "' selected>" . $row["descripcion"] . "</option>";
                        } else {
                            echo "<option value='" . $row["idNivel"] . "'>" . $row["descripcion"] . "</option>";
                        }

                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Agrega la segunda columna aquí -->
        <div class="col-md-6">
            <!-- Contenido de la segunda columna -->
            <div class="form-group">
                <label for="identificacion">Ingresa Identificación:</label>
                <input type="text" class="form-control" id="identificacion" name="identificacion" required>
            </div>
            <div class="form-group">
                <label for="apellidos">Ingresa Apellidos:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
            </div>
            <div class="form-group">
                <label for="grado" class="form-label">Seleccione Grado:</label>
                <select name="grado" id="matriculaSelect" class="form-select" disabled>
                    <?php
                    while ($row = $result_grado->fetch_assoc()) {
                        if ($idGrado == $row["idGrado"]) {
                            echo "<option value='" . $row["idGrado"] . "' selected>" . $row["descripcion"] . "</option>";
                        } else {
                            echo "<option value='" . $row["idGrado"] . "'>" . $row["descripcion"] . "</option>";
                        }

                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="mt-3">
            <input type="hidden" name="guardarMatricula">
            <button type="submit" class="btn btn-primary">Registrar Matrícula</button>
        </div>
    </div>

    </form>




    </div>
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

            // Realizar una solicitud AJAX al servidor
            $.ajax({
                type: 'POST',
                url: 'models/dbmatricula.php', // Ruta al archivo PHP que procesará la solicitud
                data: { idTipoMatricula: selectedValue == "" ? 0 : selectedValue },
                success: function (response) {
                    // Actualizar el contenido de la tarjeta con la respuesta del servidor
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

        if (parseInt(idTipoMat) === 1) { // ID Traslado externo
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