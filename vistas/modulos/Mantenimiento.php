<div class="content-wrapper">
  <!-- Encabezado de la pagina -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Mantenimiento</h1>
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

  <!-- Inicio de la tabla -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <table id="tblMantenimiento" class="table table-bordered table-striped">
                <thead class="bg-dark">
                  <tr>
                    <th>ID</th>
                    <th>Numero de serie</th>
                    <th>Etiqueta</th>
                    <th>Descripcion</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $item = null;
                  $valor = null;
                  $mantenimientos = ControladorMantenimiento::ctrMostrarMantenimientos($item, $valor);

                  if (!empty($mantenimientos) && is_array($mantenimientos)) {
                    foreach ($mantenimientos as $key => $value) {
                      echo '
                        <tr>
                          <td>' . $value["equipo_id"] . '</td>
                          <td>' . $value["numero_serie"] . '</td>
                          <td>' . $value["etiqueta"] . '</td>
                          <td>' . $value["descripcion"] . '</td>
                          <td>
                            <div class="btn-group">
                              <button title="Finalizar mantenimiento" class="btn btn-default btn-sm btnFinalizarMantenimiento" data-id="' . $value["equipo_id"] . '" data-toggle="modal" data-target="#modalFinalizarMantenimiento">
                                <i class="fas fa-tools"></i>
                              </button>
                            </div>
                          </td>
                        </tr>';
                    }
                  } else {
                    echo '<tr><td colspan="6" class="text-center">No hay equipos en mantenimiento</td></tr>';
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

<!-- Modal Finalizar Mantenimiento -->
<div class="modal fade" id="modalFinalizarMantenimiento" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Detalles del Equipo</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="formFinalizarMantenimiento" method="post">
        <input type="hidden" id="equipoId" name="equipoId">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-5 text-center border-right">
              <div class="equipment-image mb-2">
                <i class="fas fa-desktop fa-5x text-info"></i>
              </div>
              <span id="equipoEtiqueta" class="d-block font-weight-bold h6"></span>
              <div class="card card-info mt-2">
                <div class="card-header py-2">
                  <h3 class="card-title small"><i class="fas fa-info-circle mr-1"></i>Información del Equipo</h3>
                </div>
                <div class="card-body p-2">
                  <table class="table table-sm small">
                    <tbody>
                      <tr>
                        <th class="w-25"><i class="fas fa-barcode mr-1"></i>Serie:</th>
                        <td id="equipoSerie" class="text-muted"></td>
                      </tr>
                      <tr>
                        <th><i class="fas fa-info-circle mr-1"></i>Descripción:</th>
                        <td id="equipoDescripcion" class="text-muted"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-md-7">
              <div class="p-3">
                <h5 class="border-bottom pb-2 text-info">
                  <i class="fas fa-tools mr-2"></i>Estado del Mantenimiento
                </h5>


                <div class="form-group">
                  <label class="mb-2">
                    <strong> Nivel de Gravedad:</strong>
                  </label>

                  <div class="row">
                    <div class="col-md-6">

                      <div class="custom-control custom-radio me-4 mb-3">
                        <input type="radio" id="sinNovedad" name="gravedad" value="ninguno" class="custom-control-input" required>
                        <label class="custom-control-label" for="sinNovedad">
                          <i class="fas fa-check-circle text-success me-2"></i>Sin novedad
                        </label>
                      </div>


                      <div class="custom-control custom-radio me-4 mb-3">
                        <input type="radio" id="problemaLeve" name="gravedad" value="leve" class="custom-control-input">
                        <label class="custom-control-label" for="problemaLeve">
                          <i class="fas fa-exclamation-circle text-warning me-2"></i>Problema leve
                        </label>
                      </div>

                      <div class="custom-control custom-radio me-4 mb-3">
                        <input type="radio" id="problemaGrave" name="gravedad" value="grave" class="custom-control-input">
                        <label class="custom-control-label" for="problemaGrave">
                          <i class="fas fa-exclamation-triangle text-danger me-2"></i>Problema grave
                        </label>
                      </div>

                      <div class="custom-control custom-radio mb-3">
                        <input type="radio" id="problemaInreparable" name="gravedad" value="inrecuperable" class="custom-control-input">
                        <label class="custom-control-label" for="problemaInreparable">
                          <i class="fas fa-times-circle text-danger me-2"></i>Irreparable
                        </label>
                      </div>

                    </div>
                  </div>
                </div>

                <div class="form-group mt-4">
                  <label for="descripcionProblema" class="font-weight-bold">
                    <i class="fas fa-clipboard mr-2"></i>Descripción del problema:
                  </label>
                  <textarea class="form-control" id="descripcionProblema" name="detalles" rows="4" required></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-lg px-5" data-dismiss="modal">
            <i class="fas fa-times mr-1"></i>
            Cancelar
          </button>
          <?php
          if (ControladorValidacion::validarPermisoSesion([21])) {
            echo '<button type="submit" class="btn btn-info btn-lg px-5" id="btnGuardarMantenimiento">
                    <i class="fas fa-check-circle mr-2"></i>Finalizar Mantenimiento
                  </button>';
          }
          ?>

        </div>
      </form>

    </div>
  </div>
</div>