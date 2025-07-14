  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Inicio</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            </ol>
          </div>
           <div class="col-lg-3 col-12">
                    <!-- small box -->
          <?php
                    $conteos = ControladorSolicitudes::ctrContarEquiposPorCategoria();
                    $conteos2 = ControladorSolicitudes::ctrContarEquiposPorReserva();
                    
                    ?>
                    <div class="small-box bg-info">
                        <div class="inner">
                           <h3>Portátiles</h3>
                            <p><strong>Disponibles:</strong> <?php echo isset($conteos[1]) ? $conteos[1] : 0; ?></p>
                            <p><strong>Reservados:</strong> <?php echo isset($conteos2[1]) ? $conteos2[1] : 0; ?></p>
                            
                            

                        </div>
                        <div class="icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-12">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>Sonido</h3>
                            <p><strong>Disponibles:</strong> <?php echo isset($conteos[3]) ? $conteos[3] : 0; ?></p>
                            <p><strong>Reservados:</strong> <?php echo isset($conteos2[3]) ? $conteos2[3] : 0; ?></p>

                            
                        </div>
                        <div class="icon">
                            <i class="fas fa-volume-up"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-12">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                             <h3>Videobeam</h3>
                            <p><strong>Disponibles:</strong> <?php echo isset($conteos[2]) ? $conteos[2] : 0; ?></p>
                            <p><strong>Reservados:</strong> <?php echo isset($conteos2[2]) ? $conteos2[2] : 0; ?></p>

                            
                        </div>
                        <div class="icon">
                            <i class="fas fa-video"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-12 ">
                    <!-- small box -->
                     <div class="small-box bg-info">
                        <div class="inner">
                           <h3>Control remoto</h3>
                            <p><strong>Disponibles:</strong> <?php echo isset($conteos[5]) ? $conteos[5] : 0; ?></p>
                            <p><strong>Reservados:</strong> <?php echo isset($conteos2[5]) ? $conteos2[5] : 0; ?></p>

                            
                        </div>
                        <div class="icon">
                            <i class="fas fa-gamepad"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                        
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->