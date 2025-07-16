<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Inicio</h1>
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
              <p><strong>Disponibles:</strong> <?php echo isset($conteos[1]) ? $conteos[1] : 0; ?><br>
                <strong>Reservados:</strong> <?php echo isset($conteos2[1]) ? $conteos2[1] : 0; ?>
              </p>

            </div>
            <div class="icon">
              <i class="fas fa-desktop"></i>
            </div>

          </div>
        </div>

        <div class="col-lg-3 col-12">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>Sonido</h3>
              <p><strong>Disponibles:</strong> <?php echo isset($conteos[3]) ? $conteos[3] : 0; ?><br>
                <strong>Reservados:</strong> <?php echo isset($conteos2[3]) ? $conteos2[3] : 0; ?>
              </p>
            </div>
            <div class="icon">
              <i class="fas fa-volume-up"></i>
            </div>

          </div>
        </div>

        <div class="col-lg-3 col-12">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>Videobeam</h3>
              <p><strong>Disponibles:</strong> <?php echo isset($conteos[2]) ? $conteos[2] : 0; ?><br>
                <strong>Reservados:</strong> <?php echo isset($conteos2[2]) ? $conteos2[2] : 0; ?>
              </p>
            </div>
            <div class="icon">
              <i class="fas fa-video"></i>
            </div>

          </div>
        </div>

        <div class="col-lg-3 col-12 ">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>Control remoto</h3>
              <p><strong>Disponibles:</strong> <?php echo isset($conteos[5]) ? $conteos[5] : 0; ?><br>
                <strong>Reservados:</strong> <?php echo isset($conteos2[5]) ? $conteos2[5] : 0; ?>
              </p>
            </div>
            <div class="icon">
              <i class="fas fa-gamepad"></i>
            </div>

          </div>
        </div>

        <!-- Contenedor principal -->
        <div class="row col-12">
          <!-- Tarjeta para Estados de Equipos -->
          <div class="col-lg-6 col-md-12">
            <div class="card">
              <div class="card-header bg-dark">
                <h3 class="card-title"><i class="fas fa-chart-pie"></i> Estados de equipos</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
              <canvas id="pie-chart-equipos" style="min-height: 250px; height: 150px;"></canvas>
              </div>
            </div>
          </div>

          <?php
          $labelsEquipos = [];
          $dataEquipos = [];
          $coloresPorEstado = [
            'Pendiente' => '#ffc107',
            'Aprobado' => '#28a745',
            'Rechazado' => '#dc3545',
            'Devuelto' => '#17a2b8',
            'Perdido' => '#673AB7',
            'En préstamo' => '#007bff'
          ];

          $graficasEstadoEquipos = ControladorInicio::ctrObtenerEstadosEquipos();

          foreach ($graficasEstadoEquipos as $key => $value) {
            $labelsEquipos[] = $value["estado"];
            $dataEquipos[] = $value["cantidad"];
            //var_dump($labelsEquipos);
            error_log(print_r($labelsEquipos, true));
          }

          $totalEquipos = array_sum($dataEquipos);

          ?>

          <!-- Tarjeta para Estados de Préstamos -->
          <div class="col-lg-6 col-md-12">
            <div class="card">
              <div class="card-header bg-dark">
                <h3 class="card-title"><i class="fas fa-chart-pie"></i> Estados de préstamos</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
              <canvas id="pie-chart-estados" style="min-height: 250px; height: 150px;"></canvas>
              </div>
            </div>
          </div>
        </div>

        <?php
        // Código PHP para obtener datos (mantenido fuera de las tarjetas)
        $estadosPrestamos = ControladorInicio::ctrObtenerPrestamosPorEstado();

        $labels = [];
        $data = [];
        $colors = [];

        $coloresPorEstado = [
          'Pendiente' => '#ffc107',
          'Aprobado' => '#28a745',
          'Rechazado' => '#dc3545',
          'Devuelto' => '#17a2b8',
          'Perdido' => '#673AB7',
          'En préstamo' => '#007bff'
        ];

        foreach ($estadosPrestamos as $estado) {
          $labels[] = $estado['estado_prestamo'];
          $data[] = $estado['cantidad'];
          $colors[] = $coloresPorEstado[$estado['estado_prestamo']] ?? '#6c757d';
        }
        ?>

        <!-- fin grafico de estado de prestamo jack -->

        <!--  grafico de prestamo por dia alonso -->
        <!-- <div class="col-sm-6"></div> -->
        <div class="col-12">
          <div class="card">
            <div class="card-header bg-dark">
              <h3 class="card-title"><i class="fas fa-chart-line"></i> Préstamos Por Día</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>

            <?php
            $prestamos = ControladorInicio::ctrObtenerPrestamosPorDia();
            $dias = [];
            $cantidades = [];

            foreach ($prestamos as $registro) {
              $dias[] = $registro['dia'];
              $cantidades[] = $registro['cantidad'];
            }

            ?>

            <div class="card-body">
              <center>
                <button type="button" class="btn btn-sm btn-info" id="semana-actual">Semana Actual</button>
                <button type="button" class="btn btn-sm btn-secondary" id="semana-anterior">Semana Anterior</button>
              </center>
            </div>

            <div class="card-body">
              <canvas id="line-chart-prestamos"
                style="min-height: 250px; height: 150px; background-color:rgba(88, 165, 216, 0.38);"></canvas>
            </div>
          </div>
        </div>
        <!-- fin grafico de estado de prestamo alonso -->
      </div><!-- /.row -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!--// TODO: Script de estados de los préstamos -->
<script>
  // Gráfica de Pie (Estados de Préstamos) - MODIFICADA CON COLORES Y PORCENTAJES
  const ctxPie = document.getElementById('pie-chart-estados').getContext('2d');
  const totalPrestamos = <?php echo array_sum($data); ?>; // Calcula el total para porcentajes

  new Chart(ctxPie, {
    type: 'pie',
    data: {
      labels: <?php echo json_encode($labels); ?>,
      datasets: [{
        data: <?php echo json_encode($data); ?>,
        backgroundColor: [
          '#FF6384', // Pendiente (Rosa)
          '#36A2EB', // Aprobado (Azul)
          '#FFCE56', // Rechazado (Amarillo)
          '#4BC0C0', // Devuelto (Turquesa)
          '#9966FF', // Perdido (Morado)
          '#FF9F40' // En préstamo (Naranja)
        ],
        borderColor: '#fff',
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'right',
          labels: {
            color: '#000',
            font: {
              size: 12
            },
            generateLabels: function(chart) {
              const data = chart.data;
              return data.labels.map((label, i) => {
                const value = data.datasets[0].data[i];
                const percentage = totalPrestamos > 0 ? Math.round((value / totalPrestamos) * 100) : 0;
                return {
                  text: `${label}: ${value} (${percentage}%)`, // Leyenda con porcentaje
                  fillStyle: data.datasets[0].backgroundColor[i],
                  hidden: false,
                  index: i
                };
              });
            }
          }
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              const label = context.label || '';
              const value = context.raw || 0;
              const percentage = totalPrestamos > 0 ? Math.round((value / totalPrestamos) * 100) : 0;
              return `${label}: ${value} (${percentage}%)`; // Tooltip con porcentaje
            }
          }
        }
      }
    }
  });

  Chart();
</script>

<!-- // TODO: Script de los estados de los equipos -->
<script>
  //Gráfico de Estados de Equipos
  var totalEquipos = <?php echo array_sum($dataEquipos); ?>; // Calcula el total para porcentajes
 
  console.log("Cantidad total de equipos es: ", totalEquipos);
  
  
  const pieChartEquipos = new Chart(document.getElementById('pie-chart-equipos'), {
    
    type: 'pie',
    data: {
      labels: <?= json_encode($labelsEquipos) ?>,
      datasets: [{
        data: <?= json_encode($dataEquipos) ?>,
        backgroundColor: [
          '#ffc107',
          '#28a745',
          '#dc3545',
          '#17a2b8',
          '#673AB7',
          '#007bff'
        ],
        borderColor: '#fff',
        borderWidth: 2
      }]
    },

    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'right',
          labels: {
            color: '#000',
            font: {
              size: 12
            },
            generateLabels: function(chart) {
              const data = chart.data;
              return data.labels.map((label, i) => {
                const value = data.datasets[0].data[i];
                const percentage = totalEquipos > 0 ? Math.round((value / totalEquipos) * 100) : 0;
                return {
                  text: `${label}: ${value} (${percentage}%)`, // Leyenda con porcentaje
                  fillStyle: data.datasets[0].backgroundColor[i],
                  hidden: false,
                  index: i
                };
              });
            }
          }
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              const label = context.label || '';
              const value = context.raw || 0;
              const percentage = totalEquipos > 0 ? Math.round((value / totalEquipos) * 100) : 0;
              return `${label}: ${value} (${percentage}%)`; // Tooltip con porcentaje
            }
          }
        }
      }
    }
  });
  

  

  document.querySelector('#leyenda-equipos').appendChild(
    generateLegendEquipos(pieChartEquipos)
  );

  
</script>