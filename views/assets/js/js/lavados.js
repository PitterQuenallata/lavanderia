$(document).ready(function () {
  // Inicializar DataTable con configuración en español
  if ($.fn.DataTable.isDataTable("#tablaLavados")) {
    $("#tablaLavados").DataTable().destroy();
  }

  $("#tablaLavados").DataTable({
    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sSearch: "Buscar:",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior",
      },
    },
  });
});

/*=============================================
EDITAR LAVADO
=============================================*/
$(".btnEditarLavado").click(function () {
  var idLavado = $(this).attr("idLavado");
  var datos = new FormData();
  datos.append("idLavado", idLavado);

  $.ajax({
    url: "./ajax/lavados.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#idLavado").val(respuesta["id_lavado"]);
      $("#editarDescripcionLavado").val(respuesta["descripcion_lavado"]);
      $("#editarTipoLavado").val(respuesta["tipo_lavado"]);
      $("#editarCostoLavado").val(respuesta["costo_lavado"]);
    },
  });
});

/*=============================================
ELIMINAR LAVADO
=============================================*/
$(".btnEliminarLavado").click(function () {
  var idLavado = $(this).attr("idLavado");

  // Construir la URL correctamente para eliminar
  var baseURL = "./lavados?idLavado=" + idLavado;

  // Llamar a la función personalizada de SweetAlert
  fncSweetAlert("confirm", "¿Está seguro de borrar el lavado?", baseURL);
});
