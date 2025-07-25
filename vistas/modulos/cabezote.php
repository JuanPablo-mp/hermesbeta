<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item">
      <a href="acerca-de" class="nav-link" title="Acerca de">
        <span class="d-none d-sm-inline">Acerca de</span>
        <i class="fas fa-info-circle d-sm-none"></i>
      </a>
    </li>
    <li>
      <pre><?php
            // el usuario debe salir y volver a entrar para recargar todos los permisos
            // print_r($_SESSION["permisos"]); 
            ?></pre>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Home -->
    <li class="nav-item">
      <a class="nav-link" href="inicio" title="Home">
        <i class="fas fa-home"></i>
      </a>
    </li>

    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown" title="Notificaciones">
      <?php
      // Obtener SOLO las notificaciones NO LEÍDAS para la campana
      $usuarioId = isset($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : null;
      $notificacionesNoLeidas = ControladorNotificaciones::listarNoLeidas($usuarioId);
      $totalNoLeidas = !empty($notificacionesNoLeidas) ? count($notificacionesNoLeidas) : 0;
      ?>

      <a class="nav-link" data-toggle="dropdown" href="#" id="campana-notificaciones" >
        <i class="far fa-bell"></i>
        <!-- Badge SOLO se muestra si hay notificaciones NO LEÍDAS -->
        <?php if ($totalNoLeidas > 0): ?>
          <span class="badge badge-warning navbar-badge" id="notification-count">
            <?php echo $totalNoLeidas; ?>
          </span>
        <?php else: ?>
          <span class="badge badge-warning navbar-badge d-none" id="notification-count"></span>
        <?php endif; ?>
      </a>

      <!-- Dropdown de notificaciones -->
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">
          <?php echo $totalNoLeidas; ?> Notificaciones
        </span>

        <div class="dropdown-divider"></div>

        <?php if (!empty($notificacionesNoLeidas)): ?>
          <!-- Mostrar solo las primeras 5 no leídas en el dropdown -->
          <?php $contador = 0; ?>
          <?php foreach ($notificacionesNoLeidas as $notificacion): ?>
            <?php if ($contador >= 5) break; ?>
            <a href="<?php echo htmlspecialchars($notificacion['url']); ?>" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i>
              <?php echo htmlspecialchars(substr($notificacion['mensaje'], 0, 50)) . '...'; ?>
              <span class="float-right text-muted text-sm">
                <?php echo htmlspecialchars($notificacion['fecha_creacion']); ?>
              </span>
            </a>
            <div class="dropdown-divider"></div>
            <?php $contador++; ?>
          <?php endforeach; ?>
        <?php endif; ?>

        <a href="notificaciones" class="dropdown-item dropdown-footer">Ver Todas las Notificaciones</a>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button" title="Pantalla Completa">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>

    <!-- user dropdown logout -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#" title="Usuario">
        <img src="<?php echo $_SESSION['foto'] ?>" class="img-circle mb-1 "
          alt="User Image"
          style="width: 20px; height: 20px; border: 1px solid #ccc;">
        <!-- <i class="fas f?a-user"></i> -->
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="salir" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
        </a>
      </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->