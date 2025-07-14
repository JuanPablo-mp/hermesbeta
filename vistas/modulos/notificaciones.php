
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Notificaciones</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Notificaciones</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php
    // Obtener el ID del usuario actual desde la sesión
    $usuarioId = isset($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : null;
    ?>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Notificaciones</h3>

              <!-- <div class="card-tools">
                <div class="input-group input-group-sm">
                  <input type="text" class="form-control" placeholder="Buscar notificaciones">
                  <div class="input-group-append">
                    <div class="btn btn-primary">
                      <i class="fas fa-search"></i>
                    </div>
                  </div>
                </div>
              </div> -->
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm btn-delete-selected">
                    <i class="far fa-trash-alt"></i>
                  </button>
                </div>
                <!-- /.float-right -->
              </div>
              <!-- notificaciones bandeja de entrada -->
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped" id = "tblNotificaciones">
                  <thead>
                    <tr>
                      <th style="width: 10px">
                      </th>
                      <th style="width: 10px"><i class="fas fa-star"></i></th>
                      <th>Nombre del Evento</th>
                      <th>Mensaje</th>
                      <th style="width: 150px">Fecha</th>
                    </tr>
                  <tbody>
                  <?php
                    // Mostrar todas las notificaciones (leídas y no leídas)
                    $todasNotificaciones = ControladorNotificaciones::listarTodas($usuarioId);
                  ?>
                  <?php if (!empty($todasNotificaciones)): ?>
                    <?php foreach ($todasNotificaciones as $notificacion): ?>
                      <tr id="notificacion-<?php echo htmlspecialchars($notificacion['id_notificaciones']); ?>">
                        <td>
                          <div class="icheck-primary">
                            <input type="checkbox" value="<?php echo htmlspecialchars($notificacion['id_notificaciones']); ?>" id="check<?php echo htmlspecialchars($notificacion['id_notificaciones']); ?>">
                            <label for="check<?php echo htmlspecialchars($notificacion['id_notificaciones']); ?>"></label>
                          </div>
                        </td>
                        <!-- marcar importante o leída/no leída -->
                      <td class="mailbox-star d-flex align-items-center justify-content-center">
                        <?php if ($notificacion['leida'] == 1): ?>
                          <a href="#">
                            <div class="rounded-circle bg-<?php echo $notificacion['tipo_notificacion']; ?>" style="width: 15px; height: 15px;"></div>
                          </a>
                        <?php else: ?>
                          <a href="#">
                            <div class="rounded-circle border" style="width: 12px; height: 12px;"></div>
                          </a>
                        <?php endif; ?>
                      </td>  
                        <!-- Nombre o tipo de evento relacionado con la notificación -->
                        <td class="mailbox-name">
                          <a href="<?php echo htmlspecialchars($notificacion['url']); ?>">
                            <?php echo "Evento #" . htmlspecialchars($notificacion['id_tipo_evento']); ?>
                          </a>
                        </td>
                        <!-- Mensaje principal de la notificación -->
                        <td class="mailbox-subject">
                          <a href="<?php echo htmlspecialchars($notificacion['url']); ?>">
                            <?php echo htmlspecialchars($notificacion['mensaje']); ?>
                          </a>
                        </td>
                        <!-- fecha de creacion de la notificación -->
                        <td class="mailbox-date">
                          <?php echo htmlspecialchars($notificacion['fecha_creacion']); ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="6" class="text-center">No hay notificaciones.</td>
                    </tr>
                  <?php endif; ?>
                  </tbody>
                </table>
                <!-- /.table -->
              </div>   <!-- /.mail-box-messages -->
            </div>   <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>