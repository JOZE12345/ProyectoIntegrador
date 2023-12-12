<?php
require 'includes/header.php';
include 'models/dbvacantes.php';
?>

<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    if(!isset($_SESSION['id_usuario'])){
        header('Location: ../index.php');
    }
?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-speedometer"></i>Estas a punto de finalizar el proceso de matricula</h1>
            <p>Realizar el pago : </p>

        </div>

        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="#">Blank Page</a></li>
        </ul>
    </div>
        <div class="container mt-5">
        <h4 class="mb-4">PAGAR AL NUMERO DE CUENTA</h4>
        <form class="mx-auto text-center">
            <div class="card-deck mt-4">
                 <div class="col-md-4">
                        <div class="card text-white bg-dark mb-3">
                            <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                                <p class="card-text mb-1" id="documentosText"> BCP : XXX-XXXX-XXXXX-XXX.</p>
                            </div>
                        </div>
                        <div class="card text-white bg-dark mb-3">
                            <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                                <p class="card-text mb-1" id="documentosText">BBVA : XXX-XXXX-XXXXX-XXX.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           <h5>PAGALO ANTES DE LAS 24 HORAS HABILES EN AGENTES O CAJEROS AUTORIZADOS</h5>
        </form>

        <div class="mt-4">
            <a href="index.php" class="btn btn-secondary">Volver al Inicio</a>
        </div>
        <!-- Agregar este código antes del cierre del body (</body>) en detalle.php -->
        <div class="modal fade" id="cargarVoucherModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles de Matrícula</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="matricula" class="form-label">Seleccione Estudiante :</label>
                <select name="matricula" class="form-select">
                    <?php
                    if ($result_matricula->num_rows > 0) {
                        while ($row = $result_matricula->fetch_assoc()) {
                            echo "<option value='" . $row["idMatricula"] . "'>" . $row["descripcion"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay registros disponibles</option>";
                    }
                    ?>
                </select>
                <div class="col-md-9">
                    <label for="fileInput" class="form-label">Cargar archivos PDF:  </label>
                    <input type="file" name="fileInput[]" id="fileInput" multiple accept=".pdf" class="form-control-file">
                </div > 


            </div>
            
        </div>
        </div>

        <!-- Modal para cargar archivo PDF -->
        <div class="modal fade" id="cargarArchivoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cargar Archivo PDF</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Aquí puedes agregar un formulario para cargar el archivo PDF -->
                <form action="procesar_archivo.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="archivoPDF">Seleccionar Archivo PDF</label>
                    <input type="file" class="form-control" id="archivoPDF" name="archivoPDF" accept=".pdf">
                </div>
                <button type="submit" class="btn btn-primary">Cargar</button>
                </form>
            </div>
            </div>
        </div>
        </div>

<!-- Agregar este script al final del body (antes de </body>) -->
<script>
  // Mostrar el modal al hacer clic en el botón "Cargar Voucher"
  document.getElementById('cargarVoucherBtn').addEventListener('click', function () {
    $('#cargarVoucherModal').modal('show');
  });
  document.querySelector('#cargarVoucherModal .close').addEventListener('click', function () {
    $('#cargarVoucherModal').modal('hide');
  });

</script>

    </div>
    
</main>

<?php
require 'includes/footer.php';
?>