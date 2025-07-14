<?php
$item = "id_modulo";
$valor = 3;
$respuesta = ControladorModulos::ctrMostrarModulos($item, $valor);
if ($respuesta["estado"] == "inactivo") {
  echo '<script>
            window.location = "desactivado";
        </script>';
}
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Devoluciones</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">inicio</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <table id="tblDevoluciones" class="table table-bordered table-striped">
                <thead class="bg-dark">
                  <tr>
                    <th>ID</th>
                    <th>Identificación</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Telefono</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Devolución</th>
                    <th>Tipo de Préstamo</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $item = null;
                  $valor = null;
                  $devoluciones = ControladorDevoluciones::ctrMostrarDevoluciones($item, $valor);

                  foreach ($devoluciones as $key => $value) {
                    echo '
                    <tr>
                      <td>' . ($key + 1) . '</td>
                      <td>' . $value["numero_documento"] . '</td>
                      <td>' . $value["nombre_usuario"] . '</td>
                      <td>' . $value["apellido_usuario"] . '</td>
                      <td>' . $value["telefono"] . '</td>
                      <td>' . $value["fecha_inicio"] . '</td>
                      <td>' . $value["fecha_fin"] . '</td>
                      <td>' . $value["tipo_prestamo"] . '</td>
                      <td class="text-center">
                        <div class="btn-group">
                            <button title="Consultar detalles de préstamo" class="btn btn-default btn-sm btnVerUsuario" data-id="' . $value["id_prestamo"] . '" data-toggle="modal" data-target="#modalVerDetallesPrestamo">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                      </td>
                    </tr>';
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Modal Ver Detalles del Préstamo (Inmediatos y de Reserva) "Modal consolidada" -->
<div class="modal fade" id="modalVerDetallesPrestamo" tabindex="-1" role="dialog" aria-labelledby="modalVerUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="modalVerUsuarioLabel">Detalles de la Devolución #<span id="idPrestamo"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Información del Usuario -->
          <div class="col-md-4 text-center">
            <img class="img-circle elevation-2 mb-3" id="userImage" src="vistas/img/usuarios/default/anonymous.png" alt="User Image" style="width: 120px; height: 120px;">
            <h4 id="userName">Nombre del Usuario</h4>
            <p class="text-muted" id="userRol">Rol</p>
          </div>

          <!-- Detalles del Préstamo -->
          <div class="col-md-8">
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-id-card"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Identificación</span>
                      <span id="prestamoIdentificacion"></span>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-phone"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Teléfono</span>
                      <span id="prestamoTelefono"></span>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-graduation-cap"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Ficha</span>
                      <span id="prestamoFicha"></span>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-id-card"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Tipo de Préstamo</span>
                      <span id="prestamoTipo"></span>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-calendar-alt"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">F. Inicio</span>
                      <span id="prestamoFechaInicio"></span>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-calendar-check"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">F. Devolución</span>
                      <span id="prestamoFechaFin"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Detalles del Equipo -->
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Equipos en Préstamo</h5>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped" class="card-body" style="width:100%" >
              <div id="equiposListContainer">
                <!-- Aquí se cargarán los detalles de cada equipo individualmente con JavaScript -->
              </div>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>