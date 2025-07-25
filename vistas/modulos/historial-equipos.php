<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Historial</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
          </ol>
        </div>
      </div>

    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Timelime example  -->
      <div class="row">
        <div class="col-md-12">
          <div class="timeline" id="trazabilidadEquipo">
          
          </div>
          <!-- Evento 1: Creación de equipo -->
        </div>
        <!-- /.timeline -->
      </div>

    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  $(document).ready(function() {
    // Obtener el ID del equipo desde la URL
    const urlParams = new URLSearchParams(window.location.search);
    const idEquipo = urlParams.get('idEquipo');

    if (!idEquipo) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se ha seleccionado un equipo para ver su historial.',
            confirmButtonColor: "#28a745"
        }); // Manejar error si no hay ID
        return;
    }

    // Hacer la petición AJAX en la nueva página
    const datos = new FormData();
    datos.append("idEquipoTrazabilidad", idEquipo);

    $.ajax({
        url: "ajax/trazabilidad.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            const $trazabilidadEquipoDiv = $("#trazabilidadEquipo");
            $trazabilidadEquipoDiv.empty(); // Limpiar contenedor
            
            respuesta.forEach(equipo => {
                const trazabilidadEquipoHTML = `
                <div class="time-label">
                    <span class="bg-green">${equipo.fecha_accion.substring(2, 10)}</span>
                </div>
                <div>
                    ${equipo.icono}
                    <div class="timeline-item">
                        <span class="time"><i class="fas fa-clock"></i> ${equipo.fecha_accion.substring(11, 16)}</span>
                        <h3 class="timeline-header bg-dark rounded-top"><a href="#">Sistema: </a>${equipo.titulo}</h3>
                        ${equipo.descripcion}
                    </div>
                </div>`;
                
                $trazabilidadEquipoDiv.append(trazabilidadEquipoHTML);
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la petición AJAX:", textStatus, errorThrown);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se ha podido obtener el historial del equipo.',
                confirmButtonColor: "#28a745"
            }); // Manejar error AJAX
        }
    });
});
</script>