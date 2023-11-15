<?php
    $alert = "";
    session_start();

    if(!empty($_SESSION['active'])) {
        header('Location: sistema/');
    } else {
        if(!empty($_POST)) {
            if(empty($_POST['usuario']) || empty($_POST['pass'])) {
                $alert = 'Todos los campos son necesarios';
            } else {
                require_once 'sistema/includes/config.php';
                $usuario = $_POST['usuario'];
                $pass = $_POST['pass'];

                $sql = "SELECT u.user_id,u.nombre,u.usuario,u.password,r.rol_id,r.nombre_rol FROM usuarios as u INNER JOIN rol as r ON u.rol = r.rol_id WHERE u.usuario = ?";
                $query = $pdo->prepare($sql);
                $query->execute(array($usuario));
                $data = $query->fetch();

                if(password_verify($pass, $data['password'])) {
                    $_SESSION['active'] = true;
                    $_SESSION['idUser'] = $data['user_id'];
                    $_SESSION['nombre'] = $data['nombre'];
                    $_SESSION['user'] = $data['usuario'];
                    $_SESSION['rol'] = $data['rol_id'];
                    $_SESSION['rol_name'] = $data['nombre_rol'];
                    $_SESSION['tiempo'];

                    header("Location: sistema/");
                } else {
                    $alert = 'El usuario o la clave son incorrectos';
                    session_destroy();
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.10.12/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>SISTEMA DE CURSOS</title>
</head>
<body>
    <header class="main-header">
        <div class="main-cont">
            <div class="desc-header">
                <img src="images/school.svg" alt="image school">
                <p>School</p>
            </div>
        </div>   
        <div class="cont-header">
            <h1>Bienvenid@</h1>
            <div class="form">
                <form action="" method="POST" onsubmit="return validar()">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" placeholder="Nombre de usuario">
                    <label for="password">Contraseña</label>
                    <input type="password" name="pass" id="pass" placeholder="Contraseña">
                    <div class="alert"><?php echo (isset($alert) ? $alert : '' ); ?></div>
                    <button type="submit">INICIAR SESION</button>
                </form>
            </div>
        </div>
       
        
    </header>

       
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.10.12/dist/sweetalert2.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>