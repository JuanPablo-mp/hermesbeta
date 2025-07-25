      <?php
        $item = "id_modulo";
        $valor = 1;
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
        <div class="col-sm-9">
          <div class="col-sm-12 d-flex justify-content-start mb-3 align-content-center">
            <h1>Inventario</h1>
            <button id="btnTourInventario" title="Haz click aquí para un tour de inventario!" class="btn btn-default ml-2 mr-2 tourButton">
              <i class="fas fa-map"></i>
            </button>
          </div>
        </div>
        <div class="row mb-3 d-flex justify-content-end">
          <div class="col-sm-9 d-flex justify-content-end">
            <div class="btn-group">
              <?php
              if (ControladorValidacion::validarPermisoSesion([1])) {
                echo '
                <button class="btn btn-primary mr-2 tourAgregarEquipo" data-toggle="modal" data-target="#modalRegistrarEquipo">
                  <i class="fas fa-plus"></i> Agregar equipo
                </button>';
              };
              if (ControladorValidacion::validarPermisoSesion([6])) {
                echo '
                <button class="btn btn-success tourImportarEquipos" data-toggle="modal" data-target="#modalImportarEquipos">
                  <i class="fas fa-upload"></i> Importar Equipos
                </button>';
              }
              ?>
            </div>
          </div>
      </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
          <table id="tblEquipos" class="table table-bordered table-striped table-hover">
            <thead class="bg-dark">
              <tr>
                <th>Id Equipo</th>
                <th>N# Serie</th>
                <th>Etiqueta</th>
                <th>Descripción</th>
                <th>Ubicación</th>
                <th>Categoría</th>
                <th>Cuentadante</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>

          </table>
        </div>
        <!-- /.card-body -->
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
   <!-- Modal para Importar equipos -->
  <div class="modal fade" id="modalImportarEquipos">
    <div class="modal-dialog modal-lg"><!-- Cambiado a modal-lg para mayor ancho -->
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h4 class="modal-title">Importar Equipos</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <form id="formImportarEquipos" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label for="archivoEquipos">Seleccionar archivo (.csv, .xlsx, .xls):</label>
                <input type="file" class="form-control-file" name="archivoEquipos" id="archivoEquipos" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
              </div>
              
              <div class="form-group col-lg-6">
                <label for="id_usuario">Cuentadante</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                  </div>
                  <?php
                  $item = null;
                  $valor = null;
                  $cuentadantes = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
                  echo '<select class="form-control" id="id_usuario" name="cuentadante_id" required>';
                  echo '<option value="">Seleccione un cuentadante</option>';
                  foreach ($cuentadantes as $key => $cuentadante) {
                    if($cuentadante["nombre_rol"] == "Almacén"){
                      echo '<option value="' . $cuentadante["id_usuario"] . '">' . $cuentadante["nombre"] . " " . $cuentadante["apellido"] . " (" . $cuentadante["nombre_rol"]. ")" .'</option>';
                    }
                  }
                  echo '</select>';
                  ?>
                </div>
              </div>
              
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Importar</button>
              </div>
              
            </form>
          </div><!-- box-body  -->
        </div><!-- modal-body  -->
      </div><!-- Modal content -->
    </div><!-- modal-dialog  -->
  </div><!-- modal  -->
  <!------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------>


  <!-- ========== Start Section ==========
  MODAL PARA INGRESAR EQUIPO
  ========== End Section ========== -->

  <div class="modal fade" id="modalRegistrarEquipo">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-blue">
          <h4 class="modal-title">Agregar equipo</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post">
            <div class="form-row">
              <div class="form-group col-lg-6">
                <label for="numeroSerie">#Número Serie</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                  </div>
                  <input type="text" class="form-control" id="numeroSerie" name="numero_serie" placeholder="Ej:00ks32.." required>
                </div>
              </div>
              <div class="form-group col-lg-6">
                <label for="etiqueta">Etiqueta</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                  </div>
                  <input type="text" class="form-control" id="etiqueta" name="etiqueta" placeholder="Ej:0022338..." required>
                </div>
              </div>
            </div>
            <div class="form-group col-lg-12">
              <label for="descripcion">Descripción</label>
              <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Ej: Lenovo ThinkPad" rows="3" required></textarea>
            </div>
            <div class="form-row">
              <div class="form-group col-lg-6">
                <label for="categoria_id">Categoría</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                  </div>
                  <?php
                  $item = null;
                  $valor = null;
                  $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
                  echo '<select class="form-control" id="categoria_id" name="categoria_id" required>';
                  echo '<option value="">Seleccione una categoría</option>';
                  foreach ($categorias as $key => $categoria) {
                    echo '<option value="' . $categoria["categoria_id"] . '">' . $categoria["nombre"] . '</option>';
                  }
                  echo '</select>';
                  ?>
                </div>
              </div>
              <div class="form-group col-lg-6">
                <label for="id_usuario">Cuentadante</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                  </div>
                  <?php
                  $item = null;
                  $valor = null;
                  $cuentadantes = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
                  echo '<select class="form-control" id="id_usuario" name="cuentadante_id" required>';
                  echo '<option value="">Seleccione un cuentadante</option>';
                  foreach ($cuentadantes as $key => $cuentadante) {
                    if($cuentadante["nombre_rol"] == "Almacén"){
                      echo '<option value="' . $cuentadante["id_usuario"] . '">' . $cuentadante["nombre"] . " " . $cuentadante["apellido"] . " (" . $cuentadante["nombre_rol"]. ")" .'</option>';
                    }
                  }
                  echo '</select>';
                  ?>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            <?php
            ControladorEquipos::ctrAgregarEquipos();
            ?>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- ========== Start Section ==========
  MODAL PARA EDITAR EQUIPO
  ========== End Section ========== -->

  <div class="modal fade" id="modalEditarEquipo">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h4 class="modal-title">Editar equipo</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post">
            <input type="hidden" id="idEditEquipo" name="idEditEquipo">
            <div class="form-row">
              <div class="form-group col-lg-6">
                <label for="numeroSerieEdit">#Número Serie</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                  </div>
                  <input type="text" class="form-control" id="numeroSerieEdit" name="numeroSerieEdit" placeholder="Ej:00ks32.." readonly>
                </div>
              </div>
              <div class="form-group col-lg-6">
                <label for="etiquetaEdit">Etiqueta</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                  </div>
                  <input type="text" class="form-control" id="etiquetaEdit" name="etiquetaEdit" placeholder="Ej:0022338...">
                </div>
              </div>
            </div>
            <div class="form-group col-lg-12">
              <label for="descripcionEdit">Descripción</label>
              <textarea class="form-control" id="descripcionEdit" name="descripcionEdit" placeholder="Ej: El equipo se encuentra en perfecto estado..." rows="3"></textarea>
            </div>
            <div class="form-row mt-2">
              <div class="form-group col-lg-6">
                <label for="estadoEdit">Estado</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                  </div>
                  <?php
                  $item = null;
                  $valor = null;
                  $estados = ControladorEstados::ctrMostrarEstados($item, $valor);
                  echo '<select class="form-control" id="estadoEdit" name="estadoEdit">';
                  echo '<option value="">Seleccione un estado</option>';
                  foreach ($estados as $key => $estado) {
                    echo '<option value="' . $estado["id_estado"] . '">' . $estado["estado"] . '</option>';
                  }
                  echo '</select>';
                  ?>
                </div>
              </div>
              <div class="form-group col-lg-6">
                <label for="categoriaEditId">Categoría</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                  </div>
                  <?php
                  $item = null;
                  $valor = null;
                  $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
                  echo '<select class="form-control" id="categoriaEditId" name="categoriaEditId" required>';
                  echo '<option value="">Seleccione una categoría</option>';
                  foreach ($categorias as $key => $categoria) {
                    echo '<option value="' . $categoria["categoria_id"] . '">' . $categoria["nombre"] . '</option>';
                  }
                  echo '</select>';
                  ?>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Editar</button>
            </div>

            <?php
            $equipos = ControladorEquipos::ctrEditarEquipos();

            ?>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- ========== Start Section ==========
  MODAL PARA TRASPASO EQUIPO CUENTADANTE
  ========== End Section ========== -->

  <div class="modal fade" id="modalTraspaso">
    <div class="modal-dialog modal-default">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h4 class="modal-title">Solicitud de traspaso de equipo</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post">
            <input type="hidden" id="idTraspasoEquipo" name="idTraspasoEquipo">

            <div class="form-row ">

              <!-- INPUT CUENTADANTE ORIGEN -->
              <div class="form-group col-lg-12">
                <label for="cuentadanteOrigenTraspaso">Cuentadante origen</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" id="cuentadanteOrigenTraspaso" name="cuentadanteOrigenTraspaso" readonly>
                </div>
              </div>

            </div>

            <div class="form-row mt-2 d-flex justify-content-lg-center ">
              <!-- ICONO TRASPASO -->
              <div class="form-group col-lg-2 d-flex justify-content-center align-content-end">
                <span class="input-group-text mt-4 h-80"><i class="fas fa-exchange-alt fa-rotate-90"></i></span>
              </div>

              <!-- INPUT BUSCAR POR CEDULA -->
              <div class="form-group col-lg-12">
                <label for="buscarDocumentoId">Ingrese a buscar por documento</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                  </div>
                  <input type="number" class="form-control" id="buscarDocumentoId" name="buscarDocumentoId" placeholder="Ej:12345..." required>
                  <div class="input-group-append">
                    <button class="bg-primary input-group-text btnBuscarCuentadante swalDefaultError"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </div>

              <!-- INPUT CUENTADANTE DESTINO -->
              <div class="form-group col-lg-12">
                <label for="cuentadanteDestino">Cuentadante destino</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-astronaut"></i></span>
                  </div>
                  <input type="hidden" id="cuentadanteDestinoId" name="cuentadanteDestinoId">
                  <input type="text" class="form-control" id="cuentadanteDestino" name="cuentadanteDestino" placeholder="Ej:Jane Doe" readonly>
                </div>
              </div>

            </div>

            <div class="modal-footer mt-2 justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Realizar traspaso</button>
            </div>
            <?php
            // $cuentadantes = ControladorEquipos::ctrRealizarTraspasoCuentadante();
            $cuentadantes = new ControladorEquipos();
            $cuentadantes->ctrRealizarTraspasoCuentadante();
            ?>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- ========== Start Section ==========
  MODAL PARA TRASPASO EQUIPO UBICACIÓN
  ========== End Section ========== -->

  <div class="modal fade" id="modalTraspasoUbicacion">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h4 class="modal-title">Solicitud de traspaso de ubicacion</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post">
          <div class="modal-body">
            <!-- Id del equipo -->
            <input type="hidden" id="idTraspasoUbicacion" name="idTraspasoUbicacion">

            <div class="form-row d-flex justify-content-between align-items-center">

              <!-- INPUT UBICACIÓN ACTUAL -->
              <div class="form-group col-lg-5">
                <label for="ubicacionActual">Ubicación actual</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                  </div>
                  <input type="hidden" id="ubicacionActualId" name="ubicacionActualId" value="">
                  <input type="text" class="form-control" id="ubicacionActual" name="ubicacionActual" readonly>
                </div>
              </div>

              <!-- ICONO TRASPASO -->
              <div class="form-group col-lg-1 mt-4">
                <span class="input-group-text p-2"><i class="fas fa-exchange-alt d-flex justify-content-center w-100"></i></span>
              </div>

              <div class="form-group col-lg-5">
                <label for="nuevaUbicacionId">Nueva ubicacion</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                  </div>
                  <?php

                  $item = null;
                  $valor = null;
                  $ubicaciones = ControladorUbicaciones::ctrMostrarUbicaciones($item, $valor);
                  // echo '<input type="hidden" id="nueva_ubicacion_id" name="nueva_ubicacion_id">';
                  echo '<select class="form-control" id="nuevaUbicacionId" name="nuevaUbicacionId" required>';
                  echo '<option value="">Seleccione una ubicación</option>';
                  foreach ($ubicaciones as $key => $ubicacion) {
                    echo '<option value="' . $ubicacion["ubicacion_id"] . '">' . $ubicacion["nombre"] . '</option>';
                  }
                  echo '</select>';
                  ?>
                </div>
              </div>

            </div>
          </div>

          <div class="modal-footer mt-2 justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Realizar traspaso</button>
          </div>
          <?php
          // $cuentadantes = ControladorEquipos::ctrRealizarTraspasoUbicacion();
          $ubicacion = new ControladorEquipos();
          $ubicacion->ctrRealizarTraspasoUbicacion();
          ?>
        </form>
      </div>
    </div>
  </div>