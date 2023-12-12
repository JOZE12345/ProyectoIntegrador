<?php

    session_start();
     if (!empty($_POST)) {
        if (empty($_POST['admin']) || empty($_POST['passadmin'])) {
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"></button>Todos los campos son necesarios</div>';
        } else {
            require_once 'conexion.php';
            $admin = $_POST['admin'];
            $passadmin = $_POST['passadmin'];

            $sql = 'SELECT * FROM usuarios AS u INNER JOIN tipousuario AS t ON u.idTipoUsuario = t.idTipoUsuario WHERE t.idTipoUsuario = 1 and  u.identificacion = ?';
            $query = $pdo->prepare($sql);
            $query->execute(array($admin));
            $result = $query->fetch(PDO::FETCH_ASSOC);

            if ($query->rowCount() > 0) {
                if ($passadmin === $result['contraseña']) {
                    $_SESSION['activeA'] = true;
                    $_SESSION['id_Admin'] = $result['idUsuario'];
                    $_SESSION['nombre_A'] = $result['nombre'];
                    $_SESSION['rolA'] = $result['idTipoUsuario'];
                    $_SESSION['nombre_rola'] = $result['descripcion'];
                    
                    $_SESSION['email_A'] = $result['email'];
                    $_SESSION['contraseña_A'] = $result['contraseña'];
                    echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"></button>Redireccionando</div>';
                } else {
                    echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"></button>Usuarios o Clave incorrectos</div>';
                }
            } else {
                echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"></button>asd</div>';
            }
        }
    }
?>