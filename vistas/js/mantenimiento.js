$(document).ready(function () {
  $(".btnFinalizarMantenimiento").click(function () {
    var btn = $(this);
    var fila = btn.closest("tr");

    // Datos del equipo
    $("#idMantenimiento").val(btn.data("id"));
    $("#equipoSerie").text(fila.find("td:eq(2)").text()); // Columna 2 es número de serie
    $("#equipoEtiqueta").text(fila.find("td:eq(3)").text()); // Columna 3 es etiqueta
    $("#equipoDescripcion").text(fila.find("td:eq(4)").text()); // Columna 4 es descripción

    // Datos del usuario (obtenidos de los atributos data)
    var usuarioTd = fila.find("td.d-none"); // Usamos la clase d-none que tiene los datos
    $("#nombre").text(usuarioTd.data("nombre"));
    $("#apellido").text(usuarioTd.data("apellido"));
    $("#condicion").text(usuarioTd.data("condicion"));

    $("#modalFinalizarMantenimiento").modal("show");
  });

  $("#formFinalizarMantenimiento").on("submit", function (e) {
    e.preventDefault();

    var idMantenimiento = $("#idMantenimiento").val();
    var gravedad = $("input[name='gravedad']:checked", this).val();
    var detalles = $("#descripcionProblema").val();

    $.ajax({
      url: "ajax/mantenimiento.ajax.php",
      method: "POST",
      data: {
        idMantenimiento: idMantenimiento,
        gravedad: gravedad,
        detalles: detalles,
      },
      success: function (respuesta) {
        if (respuesta === "ok") {
          Swal.fire({
            icon: "success",
            title: "Mantenimiento finalizado correctamente",
            showConfirmButton: false,
            timer: 1500,
          }).then(() => location.reload());
        } else {
          Swal.fire(
            "Error",
            respuesta || "No se pudo finalizar el mantenimiento",
            "error"
          );
        }
      },
      error: function (xhr, status, error) {
        Swal.fire(
          "Error",
          "Error en la comunicación con el servidor: " + error,
          "error"
        );
      },
    });
  });
});