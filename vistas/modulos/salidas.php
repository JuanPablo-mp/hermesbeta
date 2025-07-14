
<?php
    $item = "id_modulo";
    $valor = 4;
    $respuesta = ControladorModulos::ctrMostrarModulos($item, $valor);
    if ($respuesta["estado"] == "inactivo") {
        echo '<script>
            window.location = "desactivado";
        </script>';
    }
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Salidas</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="tblSedes" class="table table-bordered table-striped">
                                <thead class="bg-dark">
                                    <tr>
                                        <th>ID Préstamo</th>
                                        <th>Usuario</th>
                                        <th>Tipo de Préstamo</th>
                                        <th>Estado De Préstamo</th>
                                        <th>Coor</th>
                                        <th>Tic</th>
                                        <th>Alm</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $item = null;
                                    $valor = null;
                                    $salidas = Controladorsalidas::ctrMostrarsalidas($item, $valor);

                                    foreach ($salidas as $key => $value) {
                                        $item = "id_prestamo";
                                        $valor = $value["id_prestamo"];
                                        $autorizaciones = ControladorAutorizaciones::ctrMostrarAutorizaciones($item, $valor);
                                        // var_dump($autorizaciones);
                                        if (($value["tipo_prestamo"] == "Reservado")){
                                        echo '
                                        <tr>
                                            <td>' . $value["id_prestamo"] . '</td>
                                            <td>' . $value["nombre"] . '</td>
                                            <td>' . $value["tipo_prestamo"] . '</td>
                                            <td>' . $value["estado_prestamo"] . '</td>';
                                                if (isset($autorizaciones["firma_coordinacion"]) && $autorizaciones["firma_coordinacion"] == "Firmado") {
                                                    echo '<td><input type="checkbox" checked disabled title="Aprobado por '. $autorizaciones["nombre_usuario_coordinacion"] .'">' . '</td>';
                                                } else {
                                                    echo '<td><input type="checkbox" disabled title="En trámite...">' . '</td>';
                                                }
                                                if (isset($autorizaciones["firma_lider_tic"]) && $autorizaciones["firma_lider_tic"] == "Firmado") {
                                                    echo '<td><input type="checkbox" checked disabled title="Aprobado por '. $autorizaciones["nombre_usuario_lider_tic"] .'">' . '</td>';
                                                } else {
                                                    echo '<td><input type="checkbox" disabled title="En trámite...">' . '</td>';
                                                }
                                                if (isset($autorizaciones["firma_almacen"]) && $autorizaciones["firma_almacen"] == "Firmado") {
                                                    echo '<td><input type="checkbox" checked disabled title="Aprobado por '. $autorizaciones["nombre_usuario_almacen"] .'">' . '</td>';
                                                } else {
                                                    echo '<td><input type="checkbox" disabled title="En trámite...">' . '</td>';
                                                }
                                                echo '<td>
                                                    <div class="btn-group">
                                                        <button title="Ver detalles" class="btn btn-default btn-sm btnVerDetalles" data-id="' . $value["id_prestamo"] . '" data-toggle="modal" data-target="#modalDetallesPrestamo">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>';
                                        }
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

<!-- Modal de Detalles del Préstamo -->
<div class="modal fade" id="modalDetallesPrestamo" tabindex="-1" role="dialog" aria-labelledby="modalDetallesPrestamoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Detalle del Préstamo #<span id="numeroPrestamo"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    
                     <!-- Información del Usuario -->
                <div class="col-md-3 text-center">
            <div class="user-avatar">
              <img class="img-circle elevation-2 mb-3" id="imgUsuario" src="vistas/img/usuarios/default/anonymous.png" alt="User Image" style="width: 120px; height: 120px;">
            </div>
            <h5 class="mb-1" id="usuarioNombre">Nombre del solicitante</h5>
            <p class="text-muted" id="userRol">Aprendiz</p>
          </div>

                             <!-- Informacion de usuario y prestamo -->
          <div class="col-md-9 col-sm-12">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="info-box">
                  <span class="info-box-icon bg-info"><i class="fas fa-id-card"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Identificación</span>
                    <span class="info-box-number" id="usuarioIdentificacion">Identificación</span>
                  </div>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="info-box">
                  <span class="info-box-icon bg-info"><i class="fas fa-phone"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Teléfono</span>
                    <span class="info-box-number" id="usuarioTelefono">000000</span>
                  </div>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="info-box">
                  <span class="info-box-icon bg-info"><i class="fas fa-graduation-cap"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Ficha</span>
                    <span class="info-box-number" id="usuarioFicha">2847523</span>
                  </div>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="info-box">
                  <span class="info-box-icon bg-info"><i class="fas fa-comment"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Motivo</span>
                    <span class="info-box-number" id="detalleMotivoPrestamo">aaaa</span>
                  </div>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="info-box">
                  <span class="info-box-icon bg-info"><i class="fas fa-calendar-alt"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Fecha Inicio</span>
                    <span class="info-box-number" id="detalleFechaInicio">2025-06-27</span>
                  </div>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="info-box">
                  <span class="info-box-icon bg-info"><i class="fas fa-calendar-check"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Fecha Devolución</span>
                    <span class="info-box-number" id="detalleFechaFin">2025-07-05</span>
                  </div>
                </div>
              </div>

             </div>
            <!-- row  -->

            <!-- Estado -->
            <div class="row">
              <div class="col-12">
                <div class="callout callout-success" id="estadoCallout">
                  <h5><i class="fas fa-check"></i> Estado:</h5>
                  <span class="badge badge-success badge-lg" id="estadoPrestamo">Autorizado</span>
                </div>
              </div>
            </div>

          </div>
          <!-- Cierra informacion de usuario y prestamo -->

        
        
        
        <!-- row  -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Equipos Solicitados</h5>
                        </div>
                        <div class="card-body">
                            <table id="tblDetallePrestamo" class="table table-bordered table-striped" style="width: 100%">
                                <thead class="bg-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Categoría</th>
                                        <th>Equipo</th>
                                        <th>Etiqueta</th>
                                        <th>Serial</th>
                                        <th>Ubicación</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
                <form method="POST">
                    <!-- creamos dos input oculos para enviar los datos al controlador -->
                    <input type="hidden" id="idUsuarioAutorizaSalida" name="idUsuarioAutorizaSalida" value="<?php echo $_SESSION['id_usuario'] ?>">
                    <input type="hidden" id="idPrestamoSalida" name="idPrestamoSalida" value="">

                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <?php
                    if (ControladorValidacion::validarPermisoSesion([16])) {
                        echo '<button type="submit" class="btn btn-success" id="btnAceptarPrestamo">Aceptar</button>';
                    }

                    $aceptarSalida = new Controladorsalidas();
                    $aceptarSalida->ctrAceptarSalida();
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>
            