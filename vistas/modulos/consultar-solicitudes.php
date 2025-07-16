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
                <div class="col-md-4">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Buscar Usuario</h3>
                        </div>
                        <div class="card-body">
                            <div class="input-group">
                                <input type="text" id="cedulaUsuario" class="form-control"
                                    placeholder="Ingrese número de cédula">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" id="btnBuscarUsuarioConsultar">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Information Card -->
                    <div class="card card-info d-none" id="userinfo">
                        
                        <div class="card-header">
                            <h3 class="card-title">Información del Usuario</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <dl class="row">
                                        <input type="hidden" id="userId">
                                        <dt class="col-sm-4">Nombres:</dt>
                                        <dd class="col-sm-8" id="userNames">-</dd>

                                        <dt class="col-sm-4">Apellidos:</dt>
                                        <dd class="col-sm-8" id="userLastName">-</dd>
                                    </dl>
                                </div>
                                <div class="col-md-12">
                                    <dl class="row">
                                        <dt class="col-sm-4">Dirección:</dt>
                                        <dd class="col-sm-8" id="userAddress">-</dd>

                                        <dt class="col-sm-4">Teléfono:</dt>
                                        <dd class="col-sm-8" id="userPhone">-</dd>
                                    </dl>
                                </div>
                                <div class="col-md-12">
                                    <dl class="row">
                                        <dt class="col-sm-4">Correo:</dt>
                                        <dd class="col-sm-8" id="userEmail">-</dd>

                                        <dt class="col-sm-4">Rol:</dt>
                                        <dd class="col-sm-8" id="userRole">-</dd>
                                    </dl>
                                </div>

                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary btn-block d-none" id="btnVolverSolicitudes">
                        <i class="fas fa-arrow-left"></i> Volver
                    </button>
                    <!-- <button class="btn btn-secondary" id="btnVolverSolicitudes">
                    <i class="fas fa-arrow-left"></i> Volver
                    </button> -->
                </div>

                <!-- Tabla de Préstamos -->

                <div class="card card-success col-md-8" id="resultados" style="display: none;">
                    <div class="card-header">
                        <h3 class="card-title">Préstamos del Usuario</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped" id="tblPrestamosUsuario">
                            <thead class="thead-dark">
                                <tr>
                                    <th># </th>
                                    <th>Préstamo</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>Estado</th>
                                    <th>Motivo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se cargarán los datos de los préstamos dinamicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </section>
</div>


<!-- Modal para mostrar el detalle del préstamo -->
<div class="modal fade" id="modal-detalle">
  <div class="modal-dialog modal-xl">
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
        </div> 



        <!-- 🔹 Tabla de Equipos Solicitados -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Equipos Solicitados</h5>
              </div>
              <div class="card-body p-10">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped" id="tblDetallePrestamo">
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
