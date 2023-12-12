<?php
require 'includes/header.php';
include 'models/dbprocesados.php';
?>

<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php');
}
?>
<style>
    a.disabled {
        pointer-events: none;
        cursor: default;
    }
</style>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-speedometer"></i>Matriculas procesadas</h1>

        </div>
    </div>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <div class="container ">

                    <button type="button" class="btn btn-primary" id="btnCargarCuentas">
                        Cuentas disponibles a pagar
                    </button>


                    <table class="table table-striped table-bordered mt-2">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Archivo Adj.</th>
                                <th>Estado</th>
                                <th>Alumno</th>
                                <th>Archivo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $indice = 1;
                            while ($row = $result_procesados->fetch_assoc()) {
                            ?>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                    <tr>
                                        <td>
                                            <?= ($indice++) ?>
                                        </td>
                                        <td>
                                            <a href="../archivos/vaucher/<?= $row['archivoVaucher'] ?>" target="_blank" class="btn btn-danger btn-sm   <?= (empty($row['archivoVaucher']) ? 'disabled' : '') ?>" title="Ver archivo adjunto">
                                                <i class="fa fa-file-pdf"></i></i>
                                            </a>
                                        </td>
                                        <td>
                                            <?= $row['estado'] ?>
                                        </td>
                                        <td>
                                            <?= $row['nombreAlumno'] . ' ' . $row['apellidoAlumno'] ?>
                                        </td>
                                        <td>
                                            <input type="file" name="fileInput" id="fileInput" multiple accept=".pdf" class="form-control" required="">
                                        </td>
                                        <td>
                                            <input type="hidden" name="idMatricula" value="<?= $row['idMatricula'] ?>">
                                            <input type="submit" name="guardarVaucher" value="Enviar" class="btn btn-primary">
                                        </td>
                                    </tr>
                                </form>

                            <?php
                            }

                            if ($indice  == 1) {
                                echo "<tr><td colspan='6' class='text-center'>No hay matriculas registradas</td></tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>



        </div>

        <div class="modal fade" id="modalCuenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">::: Numero de Cuentas a pagar :::</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 class="mb-4">PAGAR AL NUMERO DE CUENTA</h4>
                        <form class="mx-auto text-center">
                            <div class="card-deck mt-4">
                                <div class="col-md-12">
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
                            <h5>PAGALO ANTES DE LAS 24 HORAS HABILES EN AGENTES O CAJEROS AUTORIZADOS</h5>

                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</main>

<?php
require 'includes/footer.php';

?>

<script>
    document.getElementById('btnCargarCuentas').addEventListener('click', function() {
        $('#modalCuenta').modal('show');
    });

    document.querySelector('#modalCuenta .close').addEventListener('click', function() {
        $('#modalCuenta').modal('hide');
    });
</script>