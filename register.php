<?php
include 'includes/registerusuario.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/register.css">
    <link rel="stylesheet" href="css/register.css">
    <title>Registro de Usuarios</title>
</head>
<body>
    <div class="container position-relative">   
        <div class="form-container">
                <a href="index.php" class="btn btn-danger" style="float: right;">X</a>
            <h1>Registro de Apoderados</h1>
            
            <form action="./includes/registerusuario.php" method="post">
                <label for="idTipoIdentificacion">Tipo de Documento</label>
                <select name="tipo" id="matriculaSelect" class="form-select" required>
                    <?php
                    while ($row = $result_tipo->fetch_assoc()) {
                        echo "<option value='" . $row["idTipoIdentificacion"] . "'>" . $row["descripcion"] . "</option>";
                    }
                    ?>
                </select>
                
                <label for="identificacion">Número de Documento:</label>
                <input maxlength="12" minlength="8" type="text" name="identificacion" required pattern=[0-9]+
                    title="Ingresa solo números">

                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" required required pattern=[a-zA-Z]+
                    title="Ingresa solo letras"> 

                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" required pattern=[a-zA-Z]+
                    title="Ingresa solo letras">

                <label for="email">Correo Electronico:</label>
                <input type="text" name="email" required>

                <label for="sexo">Sexo:</label>
                <select name="sexo">
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                </select>

                <label for="contrasena">Contraseña:</label>
                <input type="password" name="contrasena" required>        

                <input type="submit" value="Registrar">
            </form>
            
        </div>
        
        <div class="image-container">
            <div class="visible-image"><img src="imagenes/colegio.png" alt="image school"></div>
            <p class="school-name">Colegio "Antenor Orrgeo Espinoza"</p>
        </div>
        
    </div>
    
</body>
</html>