<?php
    session_start();
    if(!empty($_SESSION['active'])){
        header('Location: usuario/');

    }else if(!empty($_SESSION['activeA'])){
        header('Location: administrador/'); 
    }
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>SISTEMA DE CURSOS</title>
</head>
<body>
    <header class="main-header">
        <div class="main-cont">
            <div class="desc-header">
                <img src="imagenes/colegio.png" alt="image school">
                <p>Colegio "Antenor Orrego Espinoza"</p>
            </div>
        </div>   
        <div class="cont-header">
            <h1>Bienvenid@</h1>
        
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Apoderado</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Administrador</button>
            </li>
        </ul>
            <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">   
                 <form action="" onsubmit="return validar()">
                    <label for="usuario">Identificacion :</label>
                    <input type="text" name="usuario" id="usuario" placeholder="DNI o Pasaporte de usuario" oninput="validarNumeros(this)">
                    <label for="password">Contraseña :</label>
                    <input type="password" name="pass" id="pass" placeholder="Contraseña">
                    <div id = "messageUsuario" ></div>
                    <button type="button" id = "loginusuario">INICIAR SESION</button>
                    ¿No estás registrado?<br>
                    <a href="./register.php?pass=1">Regístrate aquí</a>
                </form>
            </div>
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <form action="" onsubmit="return validar()">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="admin" id="admin" placeholder="DNI o Pasaporte de administrador" oninput="validarNumeros(this)">
                    <label for="password">Contraseña</label>
                    <input type="password" name="passadmin" id="passadmin" placeholder="Contraseña">
                    <div id = "messageAdministrador" ></div>
                    <button type="button" id = "loginadmin">INICIAR SESION</button>
                </form>
            </div>
            </div>

    </header>


    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="js/login.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>