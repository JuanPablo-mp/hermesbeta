    <?php
        $item = "id_modulo";
        $valor = 11;
        $respuesta = ControladorModulos::ctrMostrarModulos($item, $valor);
        if ($respuesta["estado"] == "inactivo") {
            echo '<script>
                window.location = "desactivado";
            </script>';
        }

    ?>
<?php
        $item = "id_modulo";
        $valor = 11;
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
                      <h1>Permisos</h1>
                  </div>
                  <!-- <div class="col-sm-6">
                      <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modalAddPermiso">Agregar permisos</button>
                  </div> -->
              </div>
          </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="container-fluid">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="card">
                          <div class="card-body">

                              <!-- row rol -->
                              <div class="form-group">
                                  <div class="row">

                                      <div class="col-lg-6 col-md-12">
                                          <div class="input-group ">
                                              <div class="input-group-prepend">
                                                  <span class="input-group-text"><i class="fas fa-key"></i></span>
                                              </div>
                                              <select class="form-control" id="selectRolForPermisos" name="selectRol">
                                                  <option value="">Seleccione un rol...</option>
                                                  <?php
                                                    // Fetch the list of roles
                                                    $item = null;
                                                    $valor = null;
                                                    $roles = ControladorRoles::ctrMostrarRoles($item, $valor);
                                                    // Loop through the roles and display them in the select options
                                                    foreach ($roles as $key => $value) {
                                                        if ($value["nombre_rol"] != "Administrador") {
                                                            // Only show roles that are not "Administrador"
                                                            if ($value["estado"]== "activo"){
                                                                echo '<option value="' . $value["id_rol"] . '">' . $value["nombre_rol"] . '</option>';
                                                            }
                                                        }
                                                    };
                                                    ?>
                                              </select>
                                          </div>
                                      </div>

                                      <div class="col-lg-6 col-md-12 justify-content-end float-right">
                                          <button type="button" id="activarChecks" class="btn btn-primary disabled">Seleccionar Todos</button>
                                          <button type="button" id="desactivarChecks" class="btn btn-outline-primary disabled">Deseleccionar Todos</button>
                                      </div>

                                  </div>
                                  <!-- row -->
                              </div>
                              <!-- form group -->

                          </div>
                      </div>
                  </div>
              </div>

              <div class="card d-none" id="contenidoPrincipal">
                  <div class="card-header">
                      <div id="descripcionRol" class="role-description d-none">
                          <!-- La descripción del rol se mostrará aquí -->
                      </div>
                  </div>

                  <div class="card-body">
                      <div id="contenidoPermisos" class="row d-none">
                            <!-- Aquí se cargarán los permisos del rol seleccionado -->
                      </div>
                  </div>

                  <div class="card-footer">
                      <!-- Botón Guardar -->
                      <div class="col-12">
                          <div class="d-grid gap-2 d-md-flex justify-content-md-end btn-guardar">
                              <button class="btn btn-primary" id="guardarPermisos">Guardar Cambios</button>
                          </div>
                      </div>
                  </div>
                  <!-- card -->
              </div>
          </div>    

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->