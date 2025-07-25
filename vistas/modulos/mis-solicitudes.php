<?php
$item = "id_modulo";
$valor = 2;
$respuesta = ControladorModulos::ctrMostrarModulos($item, $valor);
if ($respuesta["estado"] == "inactivo") {
    echo '<script>
            window.location = "desactivado";
        </script>';
}
?>

<!-- Contenido Principal -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Consultar Préstamos</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Tabla de Préstamos -->
                <div class="card card-success col-lg-12" id="resultados">
                    <div class="card-header">
                        <h3 class="card-title">Préstamos del Usuario</h3>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                        <?php
                        $prestamos = ControladorSolicitudes::ctrMostrarSolicitudes("usuario_id", $_SESSION['id_usuario']);
                        
                        if (!is_array($prestamos) || empty($prestamos)) {
                            // Mostrar mensaje cuando no hay préstamos
                            ?>
                            <div class="d-flex justify-content-center align-items-center" style="min-height: 100px">
                                <div class="text-center">
                                    <i class="fas fa-info-circle fa-3x text-info mb-3"></i>
                                    <h5>No hay préstamos registrados</h5>
                                </div>
                            </div>
                            <?php
                        } else {
                            // Mostrar tabla con préstamos
                            ?>
                            <table class="table table-bordered table-striped table-hover" id="tblMisPrestamosUsuario">
                                <thead class="bg-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Préstamo</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th>Estado</th>
                                        <th>Coo</th>
                                        <th>TiC</th>
                                        <th>Alm</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Función auxiliar para renderizar el estado del préstamo
                                    function renderizarEstadoPrestamo($estado) {
                                        //$estado = strtolower($estado);
                                        $clases = [
                                          'prestado' => 'btn-success',
                                          'pendiente' => 'btn-warning', 
                                          'tramite' => 'btn-primary',
                                          'devuelto' => 'btn-danger'
                                        ];
                                        
                                      $clase = isset($clases[$estado]) ? $clases[$estado] : 'btn-secundary';
                                      $texto = ucfirst($estado);    
                                      return "<button class=\"btn {$clase}\">{$texto}</button>";
                                    }
                                    
                                    // Función auxiliar para renderizar checkbox de autorización
                                    function renderizarCheckboxAutorizacion($autorizacion, $campo_firma, $campo_nombre) {
                                      if (isset($autorizacion[$campo_firma]) && $autorizacion[$campo_firma] == "Firmado") {
                                        $nombre = $autorizacion[$campo_nombre] ?? 'Usuario';
                                        return "<input type=\"checkbox\" class=\"custom-disabled\" checked title=\"Autorizado por {$nombre}\" disabled>";
                                      } else {
                                        return "<input type=\"checkbox\" title=\"En trámite...\" disabled>";
                                      }
                                    }
                                    
                                    // Verificar si es array múltiple o único registro
                                    $esArrayMultiple = is_array($prestamos) && isset($prestamos[0]) && is_array($prestamos[0]);
                                    $prestamosArray = $esArrayMultiple ? $prestamos : [$prestamos];
                                    
                                    foreach ($prestamosArray as $prestamo) {
                                        // Obtener autorizaciones para este préstamo
                                        $autorizaciones = ControladorAutorizaciones::ctrMostrarAutorizaciones("id_prestamo", $prestamo["id_prestamo"]);
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($prestamo["id_prestamo"]); ?></td>
                                            <td><?php echo htmlspecialchars($prestamo["tipo_prestamo"]); ?></td>
                                            <td><?php echo htmlspecialchars($prestamo["fecha_inicio"]); ?></td>
                                            <td><?php echo htmlspecialchars($prestamo["fecha_fin"]); ?></td>
                                            <td><?php echo renderizarEstadoPrestamo($prestamo["estado_prestamo"]); ?></td>
                                            
                                            <?php if ($prestamo["tipo_prestamo"] != "Inmediato") { ?>
                                                <!-- Coordinación -->
                                                <td><?php echo renderizarCheckboxAutorizacion($autorizaciones, "firma_coordinacion", "nombre_usuario_coordinacion"); ?></td>
                                                <!-- Líder TIC -->
                                                <td><?php echo renderizarCheckboxAutorizacion($autorizaciones, "firma_lider_tic", "nombre_usuario_lider_tic"); ?></td>
                                                <!-- Almacén -->
                                                <td><?php echo renderizarCheckboxAutorizacion($autorizaciones, "firma_almacen", "nombre_usuario_almacen"); ?></td>
                                            <?php } else { ?>
                                                <!-- Para préstamos inmediatos, no se requieren autorizaciones -->
                                                <td><i class="fas fa-ban text-danger" title="No se solicita"></i></td>
                                                <td><i class="fas fa-ban text-danger" title="No se solicita"></i></td>
                                                <td><i class="fas fa-ban text-danger" title="No se solicita"></i></td>
                                            <?php } ?>
                                            
                                            <td>
                                                <button class="btn btn-default btnVerDetalle" 
                                                        idPrestamo="<?php echo htmlspecialchars($prestamo["id_prestamo"]); ?>" 
                                                        title="Detalles del préstamo" 
                                                        data-toggle="modal" 
                                                        data-target="#modalMisDetalles">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        } // Este es el cierre del else principal
                        ?>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Detalle Préstamo -->
<div class="modal fade" id="modalMisDetalles">
  <div class="modal-dialog  modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h4 class="modal-title">Detalle del Préstamo #<span id="numeroPrestamo"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <!-- 🔹 Fila de info-boxes -->
        <div class="row">
          <!-- Tipo Préstamo -->
          <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fas fa-info"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Tipo Préstamo</span>
                <span class="info-box-number" id="detalleTipoPrestamo">aaaa</span>
              </div>
            </div>
          </div>

          <!-- Motivo -->
          <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fas fa-comment"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Motivo</span>
                <span class="info-box-number" id="detalleMotivoPrestamo">aaaa</span>
              </div>
            </div>
          </div>

          <!-- Fecha Inicio -->
          <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fas fa-calendar-alt"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Fecha Inicio</span>
                <span class="info-box-number" id="detalleFechaInicio">2025-06-27</span>
              </div>
            </div>
          </div>

          <!-- Fecha Fin -->
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

        <!-- 🔹 Estado (fuera de la fila anterior) -->
        <div class="row mt-3">
          <div class="col-12">
            <div class="callout callout-success w-100" id="estadoCallout">
              <h5><i class="fas fa-check"></i> Estado:</h5>
              <span class="badge badge-success badge-lg" id="estadoPrestamo">Autorizado</span>
               <br>
                 <small id="motivoRechazoTexto" class="text-danger" style="display: none;"></small>
            </div>
          </div>
        </div>

        <!-- 🔹 Tabla de equipos solicitados -->
        <div class="row">
          <div class="col-md-12">
            <div class="card mt-3">
              <div class="card-header">
                <h5 class="card-title">Equipos Solicitados</h5>
              </div>
              <div class="card-body p-3">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped" style="width: 100%" id="tblDetallePrestamo">
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
                    <tbody>
                      <!-- Aquí se cargarán los detalles del préstamo -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> 

      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


