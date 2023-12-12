 <?php
    session_start();

    if (!empty($_POST)) {
        if (empty($_POST['login']) || empty($_POST['pass'])) {
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"></button>Todos los campos son necesarios</div>';
        } else {
            require_once 'conexion.php';
            $login = $_POST['login'];
            $pass = $_POST['pass'];

            $sql = 'SELECT * FROM usuarios AS u INNER JOIN tipousuario AS t ON u.idTipoUsuario = t.idTipoUsuario WHERE t.idTipoUsuario = 2 and   u.identificacion = ?';
            $query = $pdo->prepare($sql);
            $query->execute(array($login));
            $result = $query->fetch(PDO::FETCH_ASSOC);

            if ($query->rowCount() > 0) {
                if ($pass === $result['contraseña']) {
                    $_SESSION['active'] = true;
                    $_SESSION['id_usuario'] = $result['idUsuario'];
                    $_SESSION['nombre'] = $result['nombre'];
                    $_SESSION['rol'] = $result['idTipoUsuario'];
                    $_SESSION['nombre_rol'] = $result['descripcion'];

                    echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"></button>Redireccionando</div>';
                } else {
                    echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"></button>Usuarios o Clave incorrectos</div>';
                }
            } else {
                echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"></button>El usuario no tiene dicho perfil</div>';
            }
        }
    }

?>