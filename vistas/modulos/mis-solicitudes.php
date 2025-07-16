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
                        <table class="table table-bordered table-striped table-hover" id="tblMisPrestamosUsuario">
                            <thead class="bg-dark">
                                <tr>
                                    <th># </th>
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
                                $item = "usuario_id";
                                $valor = $_SESSION['id_usuario'];
                                $prestamos = ControladorSolicitudes::ctrMostrarSolicitudes($item, $valor);
                                // var_dump($prestamos);

                                if (is_array($prestamos) && isset($prestamos[0]) && is_array($prestamos[0])) {
                                    // Es un array de múltiples registros
                                    foreach ($prestamos as $prestamo) {
                                        $item = "id_prestamo";
                                        $valor = $prestamo["id_prestamo"];
                                        $autorizaciones = ControladorAutorizaciones::ctrMostrarAutorizaciones($item, $valor);
                                        is_array($autorizaciones);
                                        echo '<tr>
                                                <td>' . $prestamo["id_prestamo"] . '</td>
                                                <td>' . $prestamo["tipo_prestamo"] . '</td>
                                                <td>' . $prestamo["fecha_inicio"] . '</td>
                                                <td>' . $prestamo["fecha_fin"] . '</td>
                                                <td>' . $prestamo["estado_prestamo"] . '</td>';
                                        if ($prestamo["tipo_prestamo"] != "Inmediato") {
                                            if (isset($autorizaciones["firma_coordinacion"]) && $autorizaciones["firma_coordinacion"] == "Firmado") {
                                                echo '<td><input type="checkbox" checked title="Autorizado por ' . $autorizaciones["nombre_usuario_coordinacion"] . '" disabled>' . '</td>';
                                            } else {
                                                echo '<td><input type="checkbox" title="En trámite..." disabled>' . '</td>';
                                            }
                                            if (isset($autorizaciones["firma_lider_tic"]) && $autorizaciones["firma_lider_tic"] == "Firmado") {
                                                echo '<td><input type="checkbox" checked title="Autorizado por ' . $autorizaciones["nombre_usuario_lider_tic"] . '" disabled></td>';
                                            } else {
                                                echo '<td><input type="checkbox" title="En trámite..." disabled>' . '</td>';
                                            }
                                            if (isset($autorizaciones["firma_almacen"]) && $autorizaciones["firma_almacen"] == "Firmado") {
                                                echo '<td><input type="checkbox" checked title="Autorizado por ' . $autorizaciones["nombre_usuario_almacen"] . '" disabled>' . '</td>';
                                            } else {
                                                echo '<td><input type="checkbox" title="En trámite..." disabled>' . '</td>';
                                            }
                                        } else {
                                            echo '<td><i class="fas fa-ban text-danger" title="No se solicita"></i></td>';
                                            echo '<td><i class="fas fa-ban text-danger" title="No se solicita"></i></td>';
                                            echo '<td><i class="fas fa-ban text-danger" title="No se solicita"></i></td>';
                                        }
                                        echo '<td>';
                                        echo '<button class="btn btn-default btnVerDetalle" idPrestamo="' . $prestamo["id_prestamo"] . '" title="Detalles del prestamo" data-toggle="modal" data-target="#modalMisDetalles"><i class="fas fa-eye"></i></button>';
                                        '</td>
                                            </tr>';
                                    }
                                } else if (is_array($prestamos) && isset($prestamos[0])) {
                                    echo '<tr>
                                            <td>' . $prestamos["id_prestamo"] . '</td>
                                            <td>' . $prestamos["tipo_prestamo"] . '</td>
                                            <td>' . $prestamos["fecha_inicio"] . '</td>
                                            <td>' . $prestamos["fecha_fin"] . '</td>
                                            <td>';

                                    // Botón de estado para único registro (estilo similar a usuarios.js)
                                    switch ($prestamos["estado_prestamo"]) {
                                        case 'aprobado':
                                            echo '<button class="btn btn-success">Aprobado</button>';
                                            break;
                                        case 'pendiente':
                                            echo '<button class="btn btn-warning">Pendiente</button>';
                                            break;
                                        case 'rechazado':
                                            echo '<button class="btn btn-danger">Rechazado</button>';
                                            break;
                                        case 'devuelto':
                                            echo '<button class="btn btn-info">Devuelto</button>';
                                            break;
                                        default:
                                            echo '<button class="btn btn-secondary">' . $prestamos["estado_prestamo"] . '</button>';
                                    }

                                    echo '</td>
                                            <td>' . $prestamos["motivo"] . '</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-default btnVerMisDetalles" idPrestamo="' . $prestamos["id_prestamo"] . '" title="Detalles" data-toggle="modal" data-target="#modalMisDetalles">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-default btnRenovar" title="Renovar préstamo">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                    <button class="btn btn-default btnCancelar" title="Cancelar solicitud">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <button class="btn btn-default btnComprobante" title="Descargar comprobante">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>';
                                } else {
                                    echo '<tr>
                                            <td colspan="7">No hay registros</td>
                                        </tr>';
                                }
                                ?>
                            </tbody>
                        </table>
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


<script>
    // Activar tooltips
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();

        // Función vacía para los botones sin funcionalidad
        $('.btnRenovar, .btnCancelar, .btnComprobante').click(function(e) {
            e.preventDefault();
            Toast.fire({
                icon: 'info',
                title: 'Esta funcionalidad no está implementada aún'
            });
            return false;
        });
    });
</script>