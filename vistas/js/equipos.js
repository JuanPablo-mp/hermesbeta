/* ==================================================
SERVERSIDE EQUIPOS
================================================== */

$('#tblEquipos').DataTable({
    "processing": true,
    "serverSide": true,
    "sAjaxSource": "ajax/serverside/serverside.equipos.php",
    "columns": [
        { "data": null },
        { "data": "1" },
        { "data": "2" },
        { "data": "3" },
        { "data": "4" },
        { "data": "5" },
        { "data": "6" },
        { "data": "7" },
        { "data": null }
    ],
    "columnDefs": [
        {
            "targets": [0],
            "render": function(data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            "targets": [-1],
            "render": function(data, type, row) {
                let botones = "<div class='btn-group'>";
                if (usuarioActual["permisos"].includes(3)) {
                    botones += "<button title='Editar equipo' class='btn btn-default btnEditarEquipo' idEquipo='" + row[0] + "' data-toggle='modal' data-target='#modalEditarEquipo'><i class='fas fa-edit'></i></button>";
                }

                if (usuarioActual["permisos"].includes(5)) {
                    botones += "<button title='Traspaso de cuentadante' class='btn btn-default btnTraspasarEquipo' idEquipoTraspaso='" + row[0] + "' data-toggle='modal' data-target='#modalTraspaso'><i class='fas fa-share'></i></button>";
                }

                if (usuarioActual["permisos"].includes(4)) {
                    botones += "<button title='Traspaso de ubicación' class='btn btn-default btnTraspasarUbicacion' idEquipoTraspasoUbicacion='" + row[0] + "' data-toggle='modal' data-target='#modalTraspasoUbicacion'><i class='fas fa-map-pin'></i></button>";
                }

                botones += "<button title='Ver historial' class='btn btn-default btnHistorialEquipo' idEquipoHistorial='" + row[0] + "'><i class='fas fa-clock'></i></button>" +
                    "</div>";

                return botones;
            }
        }
    ],
    "responsive": true,
    "autoWidth": false,
    "lengthChange": true,
    "lengthMenu":[10, 25, 50, 100],
    "language": {
        "lengthMenu": "Mostrar _MENU_ registros",
        "zeroRecords": "No se encontraron resultados",
        "info": "Mostrando pagina _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrado de _MAX_ total registros)",
        "search": "Buscar:",
        "paginate": {
            "first":      "Primero",
            "last":       "Ultimo",
            "next":       "Siguiente",
            "previous":   "Anterior"
        }
    },
    "buttons": ["csv", "excel", "pdf"],
    "dom": "lfBrtip"    
});

/* ==================================================
BOTÓN PARA EDITAR EQUIPOS
================================================== */
var idEquipoTraspaso;
var idEquipoTraspasoUbicacion;

$(document).on("click", ".btnEditarEquipo", function() {
    var idEquipo = $(this).attr("idEquipo");
    console.log("IdEquipo: ", idEquipo);
    
    var datos = new FormData();
    datos.append("idEquipo", idEquipo);

    $.ajax({
        url: "ajax/equipos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            console.log("Respuesta completa del servidor:", respuesta);
            
            try {
                if (respuesta) {
                    console.log("datos: ", respuesta);
                    
                    $("#idEditEquipo").val(respuesta["equipo_id"]);
                    $("#numeroSerieEdit").val(respuesta["numero_serie"]);
                    $("#etiquetaEdit").val(respuesta["etiqueta"]);
                    $("#descripcionEdit").val(respuesta["descripcion"]);
                    $("#estadoEdit").val(respuesta["id_estado"]);
                    $("#categoriaEditId").val(respuesta["categoria_id"]);
                } else {
                    console.error("Respuesta inválida del servidor");
                    alert("Error: La respuesta del servidor no tiene el formato esperado");
                }
            } catch (e) {
                console.error("Error al procesar la respuesta:", e);
                alert("Error al procesar la respuesta del servidor");
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la petición Ajax:");
            console.error("Status:", status);
            console.error("Error:", error);
            console.error("Respuesta:", xhr.responseText);
            alert("Error al comunicarse con el servidor. Por favor, intente nuevamente.");
        }
    });
});

/* ==================================================
BOTÓN PARA INSERTAR EL CUENTADANTE Y UBICACIÓN ACTUAL
================================================== */

$(document).on("click", ".btnTraspasarEquipo", function(){
    idEquipoTraspaso = $(this).attr("idEquipoTraspaso");
    console.log("Id equipo traspaso: ", idEquipoTraspaso);

    var datos = new FormData();
    datos.append("idEquipoTraspaso", idEquipoTraspaso);

    $.ajax({
        url: "ajax/equipos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            try {
                if (respuesta) {
                    console.log("datos: ", respuesta);
                    
                    $("#idEditEquipo").val(respuesta["equipo_id"]);
                    $("#cuentadanteOrigenTraspaso").val(respuesta["cuentadante_nombre"] + " (" + respuesta["nombre_rol"] + ")");
                    $("#ubicacionOrigenTraspaso").val(respuesta["ubicacion_nombre"]);
                } else {
                    console.error("Respuesta inválida del servidor");
                    alert("Error: La respuesta del servidor no tiene el formato esperado");
                }
            } catch (e) {
                console.error("Error al procesar la respuesta:", e);
                alert("Error al procesar la respuesta del servidor");
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la petición Ajax:");
            console.error("Status:", status);
            console.error("Error:", error);
            console.error("Respuesta:", xhr.responseText);
            alert("Error al comunicarse con el servidor. Por favor, intente nuevamente.");
        }
    });
});

/* ==================================================
BOTÓN PARA BUSCAR EL CUENTADANTE Y AGREGARLO EN EL INPUT
================================================== */

$(document).on("click", ".btnBuscarCuentadante", function (event){
    event.preventDefault();
    console.log("Id equipo traspaso: ", idEquipoTraspaso);

    $("#cuentadanteDestino").val("");
    $("#ubicacionTraspaso").val("");

    var buscarDocumentoId = $("#buscarDocumentoId").val();
    let datos = new FormData();

    datos.append("buscarDocumentoId", buscarDocumentoId);
    if (buscarDocumentoId === ""){
        Toast.fire({
            icon: 'info',
            title: 'Por favor ingrese un documento a buscar',
            position: "center"
        })
        return;
    } else {
        $.ajax({
            url: "ajax/equipos.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(resultado){
                const docIngresado = String(buscarDocumentoId).trim();
                const docEncontrado = String(resultado["numero_documento"] || '').trim();
                console.log("rol usuario: ", resultado["nombre_rol"]);
                if(docIngresado != docEncontrado){
                    Toast.fire({
                        icon: 'error',
                        title: 'No se encontró el documento del cuentadante',
                        position: "center"
                    });
                    $("#buscarDocumentoId").val("");
                } else if(resultado["nombre_rol"] == "Aprendiz"){
                    Toast.fire({
                        icon: 'error',
                        title: 'No se puede asignar equipo a este documento',
                        position: "center"
                    });
                    $("#buscarDocumentoId").val("");
                } else {
                    console.log("id_usuario: ", resultado["id_usuario"]);
                    $("#idTraspasoEquipo").val(idEquipoTraspaso);
                    console.log("ESTE ES EL EQUIPO ID AL CUAL VOY A PASAR: ", idEquipoTraspaso);
                    $("#cuentadanteDestinoId").val(resultado["id_usuario"]);
                    $("#cuentadanteDestino").val(resultado["cuentadante_nombre_completo"] + " (" + resultado["nombre_rol"] + ")");
                }
            }
        });
    }
});

/* ==================================================
BOTÓN PARA MOSTRAR LOS DATOS DE LA UBICACIÓN ACTUAL
================================================== */

$(document).on("click", ".btnTraspasarUbicacion", function() {
    let idEquipoTraspasoUbicacion = $(this).attr("idEquipoTraspasoUbicacion");
    console.log("equipo a trasladar:",idEquipoTraspasoUbicacion);

    let datos = new FormData();
    datos.append("idEquipoTraspasoUbicacion", idEquipoTraspasoUbicacion);

    $.ajax({
        url: "ajax/equipos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(resultado){
            console.log(resultado);
            $("#idTraspasoUbicacion").val(resultado["equipo_id"]);
            $("#ubicacionActualId").val(resultado["ubicacion_id"]);
            $("#ubicacionActual").val(resultado["ubicacion_id"] + " " + resultado["ubicacion_nombre"]);
        }
    });
});

// Activar tooltips después de cada renderizado de tabla
$('#tblEquipos').on('draw.dt', function () {
    $('[data-toggle="tooltip"]').tooltip();
});

//************************************************************
//
//  SCRIPT PARA IMPORTAR Equipos MASIVAMENTE
//
//************************************************************/
$(document).on("submit", "#modalImportarEquipos form", function(e) {
    e.preventDefault();

    var fileInput = $("#archivoEquipos");
    var file = fileInput[0].files[0];

    // Validar que se haya seleccionado un archivo
    if (!file) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor, seleccione un archivo.'
        });
        return;
    }

    // Validar tipo de archivo (CSV o Excel)
    var validExtensions = ["csv", "xlsx", "xls"];
    var fileExtension = file.name.split('.').pop().toLowerCase();
    if ($.inArray(fileExtension, validExtensions) == -1) {
        Swal.fire({
            icon: 'error',
            title: 'Archivo no válido',
            text: 'Por favor, seleccione un archivo CSV o Excel (.csv, .xlsx, .xls).'
        });
        fileInput.val(''); // Limpiar el input de archivo
        return;
    }

    var formData = new FormData();
    formData.append("archivoEquipos", file);
    formData.append("accion", "importarEquiposMasivo"); // Acción para el controlador PHP
    formData.append("cuentadante_id", $("#id_usuario").val());

    Swal.fire({
        title: 'Importando equipos...',
        text: 'Esto puede tardar un momento.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: "ajax/equipos.ajax.php", // Ruta al controlador PHP
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            
            Swal.close();
            try {
                var jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
                if (jsonResponse.status === "success") {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Importación completada!',
                        html: jsonResponse.message +
                            '<br><b>Exitosos:</b> ' + (jsonResponse.exitosos ? jsonResponse.exitosos.length : 0) +
                            '<br><b>Fallidos:</b> ' + (jsonResponse.fallidos ? jsonResponse.fallidos.length : 0),
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        confirmButtonText: "Descargar reporte",
                        showCancelButton: true,
                        cancelButtonText: "Cerrar"
                        
                    }).then((result) => {
                        if (result.isConfirmed) {
                            link.click(); // Simula el clic para descargar el reporte
                        }
                        });
                    if (jsonResponse.reporte) {
                        const contenidoBytes = Uint8Array.from(atob(jsonResponse.reporte), c => c.charCodeAt(0));
                        var blob = new Blob([contenidoBytes], {type: 'text/plain;charset=utf-8'});
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = jsonResponse.nombreArchivo;
                        
                        //Opción para descargar el reporte si lo deseas
                         //link.click();
                    }
                    $("#modalImportarEquipos").modal('hide');
                    $('#tblEquipos').DataTable().ajax.reload();
                    fileInput.val('');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en la importación',
                        text: jsonResponse.message || 'Ocurrió un error al importar los equipos.'
                    });
                }
            } catch (e) {
                console.error("Raw server response:", response);
                console.error("Error parsing JSON:", e);
                Swal.fire({
                    icon: 'error',
                    title: 'Error inesperado',
                    text: 'La respuesta del servidor no es válida. Por favor, revise el archivo e inténtelo de nuevo.'
                });
                console.error("Error parsing response: ", response);
            }
        },
        
        error: function(jqXHR, textStatus, errorThrown) {
           
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'No se pudo conectar con el servidor. Verifique su conexión e inténtelo de nuevo. Detalles: ' + textStatus + ' - ' + errorThrown
            });
            console.error("AJAX error: ", textStatus, errorThrown);
        }
    });
});