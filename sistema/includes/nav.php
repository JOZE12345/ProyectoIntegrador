<!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="./images/user.png" alt="User Image">
        <div>
          <p class="app-sidebar__user-name"><?php echo $_SESSION['rol_name'] ?></p>
          <p class="app-sidebar__user-designation"><?php echo $_SESSION['nombre']; ?></p>
        </div>
      </div>
      <ul class="app-menu">
      <?php if($_SESSION['rol'] == 1) { ?>
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
              <i class="app-menu__icon fa fa-users"></i>
              <span class="app-menu__label">Usuarios</span>
              <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a class="treeview-item" href="lista_usuarios.php"><i class="icon fa fa-circle-o"></i>Lista de Usuarios</a></li>
            </ul>
        </li>
        <?php } ?>
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
              <i class="app-menu__icon fa fa-user-graduate"></i>
              <span class="app-menu__label">Alumnos</span>
              <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a class="treeview-item" href="lista_alumnos.php"><i class="icon fa fa-circle-o"></i>Lista de Alumnos</a></li>
            </ul>
        </li>
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fas fa-chalkboard-teacher"></i>
              <span class="app-menu__label">Profesores</span>
              <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a class="treeview-item" href="lista_profesores.php"><i class="icon fa fa-circle-o"></i>Lista de Profesores</a></li>
            </ul>
        </li>
        <li>
            <a class="app-menu__item" href="lista_materias.php">
              <i class="app-menu__icon fas fa-check-circle"></i>
              <span class="app-menu__label">Materias</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item" href="lista_cursos.php">
              <i class="app-menu__icon fas fa-check-circle"></i>
              <span class="app-menu__label">Cursos</span>
            </a>
        </li>
        <?php if($_SESSION['rol'] == 1) { ?>
        <li>
            <a class="app-menu__item" href="lista_inscripciones.php">
              <i class="app-menu__icon fas fa-check-circle"></i>
              <span class="app-menu__label">Inscripcion</span>
            </a>
        </li>
        <?php } ?>
        <li>
        <li>
            <a class="app-menu__item" href="#">
              <i class="app-menu__icon far fa-file-pdf"></i>
              <span class="app-menu__label">Reportes</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item" href="logout.php">
              <i class="app-menu__icon fa fa-sign-out"></i>
              <span class="app-menu__label">Logout</span>
            </a>
        </li>
      </ul>
    </aside>