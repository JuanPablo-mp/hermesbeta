function cargarDetallesPrestamo(idPrestamo) {
    $.ajax({
        url: "ajax/prestamos.ajax.php",
        method: "POST",
        data: {
            idPrestamo: idPrestamo,
            accion: "obtenerDetalles"
        },
        dataType: 'json',
        success: function(respuesta) {
            if (respuesta) {
                $("#modalIdPrestamo").text(respuesta.id_prestamo);
                $("#modalUsuario").text(respuesta.usuario_id);
                $("#modalTipo").text(respuesta.tipo_prestamo);
                $("#modalFechaInicio").text(respuesta.fecha_inicio);
                $("#modalFechaFin").text(respuesta.fecha_fin);
                $("#modalEstado").text(respuesta.estado_prestamo);
                $("#modalMotivo").text(respuesta.motivo);
            }
        }
    });
}
$(document).on('click', '.btnVerDetalles', function () {
    var idPrestamo = $(this).data('id');
    $.ajax({
        url: "ajax/solicitudes.ajax.php",
        method: "POST",
        data: { accion: "mostrarPrestamo", idPrestamo: idPrestamo },
        dataType: "json",
        success: function (respuesta) {
            $("#numeroPrestamo").text(respuesta["id_prestamo"]);
            $("#idPrestamoSalida").val(respuesta["id_prestamo"]);
            $("#detalleTipoPrestamo").text(respuesta["estado_prestamo"]);
            $("#detalleFechaInicio").text(respuesta["fecha_inicio"].split(" ")[0]);
            $("#detalleFechaFin").text(respuesta["fecha_fin"].split(" ")[0]);
            $("#detalleMotivoPrestamo").text(respuesta["motivo"]);
            $("#estadoPrestamo").text(respuesta["estado_prestamo"]);
            $("#estadoCallout")
            .removeClass("callout-success callout-warning callout-danger callout-info");

        // Agregar nueva clase según estado
                switch (respuesta["estado_prestamo"]) {
                    case "Autorizado":
                        $("#estadoCallout").addClass("callout-success");
                        
                        break;
                    case "Pendiente":
                        $("#estadoCallout").addClass("callout-warning");
                        
                        break;
                    case "Rechazado":
                        $("#estadoCallout").addClass("callout-danger");
                        
                        break;
                    case "Tramite":
                        $("#estadoCallout").addClass("callout-info");
                        
                        break;
                }
                $("#estadoPrestamo")
                .removeClass("badge-success badge-warning badge-danger badge-primary");

            // Agregar clase según estado
            switch (respuesta["estado_prestamo"]) {
                case "Autorizado":
                    $("#estadoPrestamo").addClass("badge-success");
                    break;
                case "Pendiente":
                    $("#estadoPrestamo").addClass("badge-warning");
                    break;
                case "Rechazado":
                    $("#estadoPrestamo").addClass("badge-danger");
                    break;
                case "Tramite":
                    $("#estadoPrestamo").addClass("badge-primary");
                    break;
                 
            }
            // Datos del usuario (necesita otra consulta)
            var datosUsuario = new FormData();
            datosUsuario.append("idUsuario", respuesta["id_usuario"]);
            $.ajax({
                url: "ajax/usuarios.ajax.php",
                method: "POST",
                data: datosUsuario,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (respuestaUsuario) {
                    $("#usuarioNombre").text(respuestaUsuario["nombre"] + " " + respuestaUsuario["apellido"]);
                    $("#userRol").text(respuestaUsuario["nombre_rol"]);
                    $("#usuarioTelefono").text(respuestaUsuario["telefono"]);

                    if (respuestaUsuario["nombre_rol"] == "Aprendiz") {
                        $("#detalleUsuarioFicha").text(respuestaUsuario["codigo"]);
                    } else {
                        $("#detalleUsuarioFicha").text("N/A");
                    }

                    $("#usuarioIdentificacion").text(respuestaUsuario["tipo_documento"] + " " + respuestaUsuario["numero_documento"]
);

                    if (respuestaUsuario["foto"] != "") {
                        $("#imgUsuario").attr("src", respuestaUsuario["foto"]);
                    } else {
                        $("#imgUsuario").attr("src", "vistas/img/usuarios/default/anonymous.png");
                    }
                }
            });

            // Mostrar u ocultar el botón "Aceptar" según el estado
            if (respuesta["estado_prestamo"] === "Autorizado") {
                $("#btnAceptarPrestamo").removeClass("d-none");
            } else {
                $("#btnAceptarPrestamo").addClass("d-none");
            }


           $.ajax({
                url: "ajax/solicitudes.ajax.php",
                method: "POST",
                data: {
                    accion: "mostrarPrestamoDetalle",
                    idPrestamoDetalle: idPrestamo
                },
                dataType: "json",
                success: function (detalles) {
                    var tabla = $("#tblDetallePrestamo");

                    // Destruir DataTable si ya está inicializado
                    if ($.fn.DataTable.isDataTable(tabla)) {
                        tabla.DataTable().clear().destroy();
                    }

                    var tbody = tabla.find("tbody");
                    tbody.empty();

                    // Agregar filas
                    detalles.forEach(function (equipo) {
                        tbody.append(
                            "<tr>" +
                                "<td>" + equipo.equipo_id + "</td>" +
                                "<td>" + equipo.categoria + "</td>" +
                                "<td>" + equipo.descripcion + "</td>" +
                                "<td>" + equipo.etiqueta + "</td>" +
                                "<td>" + equipo.numero_serie + "</td>" +
                                "<td>" + equipo.ubicacion + "</td>" +
                            "</tr>"
                        );
                    });

                    // Inicializar DataTable nuevamente
                    tabla.DataTable({
                        responsive: true
                        
                        
                    });
                    $("#modalDetallesPrestamo").modal("show");

                }
            });
        }
    });
});