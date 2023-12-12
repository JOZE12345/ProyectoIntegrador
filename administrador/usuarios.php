<?php
require 'includes/header.php';
require 'models/dbUsuarios.php';
require 'models/conexion.php';
$query = "SELECT usuarios.*, 
                 tipousuario.descripcion AS tipoUsuarioDescripcion,
                 tipoidentificacion.descripcion AS tipoIdentificacionDescripcion
          FROM usuarios
          LEFT JOIN tipousuario ON usuarios.idTipoUsuario = tipousuario.idTipoUsuario
          LEFT JOIN tipoidentificacion ON usuarios.idTipoIdentificacion = tipoidentificacion.idTipoIdentificacion";
$result = $conn->query($query);
?>

<script>
    function validarNumeros(input) {
        var valor = input.value;
        // Utilizamos una expresión regular para permitir solo números
        var soloNumeros = /^[0-9]+$/;

        if (!soloNumeros.test(valor)) {
            document.getElementById("messageUsuario").innerHTML;
            input.value = valor.replace(/[^0-9]/g, ""); // Eliminamos caracteres no numéricos
        } else {
            document.getElementById("messageUsuario").innerHTML = "";
        }
    }

    // Puedes agregar más lógica de validación según tus necesidades
    function validar() {
        // Tu lógica de validación adicional aquí
        return true; // O false si no pasa la validación
    }
</script>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-speedometer"></i>Bienvenido al formulario de registro de nuevo usuario</h1>
            <p>Proceda a ingresar los datos requeridos</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
        </ul>
    </div>

    <div class="row mt-3">
        <h2 class="text-center">Agregar Nuevo Administrador</h2>
    </div>
    <div class="row">
        <form method="post" action="models/dbUsuarios.php" class="mb-3">
            <div class="row">
                <form method="post" action="models/dbUsuarios.php" class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="tipo_documento" class="form-label">Tipo de documento:</label>
                            <select name="tipo" class="form-select">
                                <option value="">Selecciona tipo de documento</option>
                                <?php
                                while ($row_tipo_documento = $result_tipo_documento->fetch_assoc()) {
                                    echo "<option value='" . $row_tipo_documento["idTipoIdentificacion"] . "'>" . $row_tipo_documento["descripcion"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="nro_documento" class="form-label">Nro de documento:</label>
                            <input maxlength="12" minlength="8" type="text" name="identificacion" class="form-control"
                                required pattern=[0-9]+ title="Ingresa solo números">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" name="nombre" class="form-control" pattern=[a-zA-Z]+
                                title="Ingresa solo letras">
                        </div>
                        <div class="col-md-4">
                            <label for="apellidos" class="form-label">Apellidos:</label>
                            <input type="text" name="apellido" class="form-control" required pattern=[a-zA-Z]+
                                title="Ingresa solo letras">
                        </div>
                    </div>
                    <div class="row mt-3">
                    <div class="col-md-4">
                            <label for="email" class="form-label">Correo Electronico:</label>
                            <input type="text" name="email" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="contrasena" class="form-label">Contraseña:</label>
                            <input type="password" name="contrasena" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="genero" class="form-label">Género:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sexo" value="M" checked>
                                <label class="form-check-label">Hombre</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sexo" value="F">
                                <label class="form-check-label">Mujer</label>
                            </div>
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
                    <h2 class="text-center">LISTA DE USUARIOS REGISTRADOS</h2>
                    <table class="table table-striped table-bordered mt-2">
                        <tr>
                            <td>Id</td>
                            <td>Identificacion</td>
                            <td>Nombre</td>
                            <td>Apellido</td>
                            <td>Sexo</td>
                            <td>Contraseña</td>
                            <td>Tipo de usuario</td>
                            <td>Tipo de identificación</td>
                            <td>Acción</td>
                        </tr>

                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . (isset($row['idUsuario']) ? $row['idUsuario'] : '') . "</td>";
                            echo "<td>" . (isset($row['identificacion']) ? $row['identificacion'] : '') . "</td>";
                            echo "<td>" . (isset($row['nombre']) ? $row['nombre'] : '') . "</td>";
                            echo "<td>" . (isset($row['apellido']) ? $row['apellido'] : '') . "</td>";
                            echo "<td>" . (isset($row['sexo']) ? $row['sexo'] : '') . "</td>";
                            echo "<td>" . (isset($row['contraseña']) ? $row['contraseña'] : '') . "</td>";
                            echo "<td>" . (isset($row['tipoUsuarioDescripcion']) ? $row['tipoUsuarioDescripcion'] : '') . "</td>";
                            echo "<td>" . (isset($row['tipoIdentificacionDescripcion']) ? $row['tipoIdentificacionDescripcion'] : '') . "</td>";
                            echo "<td><a href='models/eliminarUsuario.php?id=" . (isset($row['idUsuario']) ? $row['idUsuario'] : '') . "'>Eliminar</a></td>";
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