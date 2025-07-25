// Obteniendo el id del equipo por su trazabilidad
$(document).on("click", ".btnHistorialEquipo", function() {
    let idEquipoTrazabilidad = $(this).attr("idEquipoHistorial");
    
    if(!idEquipoTrazabilidad){
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se ha seleccionado un equipo para ver su historial.',
            confirmButtonColor: "#28a745"
        });
        return;
    }

    // Solo redirige la URL con el id del equipo
    window.location.href = `historial-equipos?idEquipo=${encodeURIComponent(idEquipoTrazabilidad)}&origin=inventario`;
});