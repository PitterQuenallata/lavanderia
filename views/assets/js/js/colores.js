$(document).ready(function () {
  // Configuración de DataTable
  if ($.fn.DataTable.isDataTable('#tablaColores')) {
    $('#tablaColores').DataTable().destroy();
  }

  $('#tablaColores').DataTable({
    "language": {
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ningún dato disponible en esta tabla",
      "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sSearch": "Buscar:",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    }
  });
});

/*=============================================
EDITAR COLOR
=============================================*/
$(".btnEditarColor").click(function () {
  var idColor = $(this).attr("idColor");
  var datos = new FormData();
  datos.append("idColor", idColor);

  $.ajax({
    url: "ajax/colores.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#idColor").val(respuesta["id_color"]);
      $("#editarNombreColor").val(respuesta["nombre_color"]);
    },
    error: function (error) {
      console.error("Error al obtener los datos del color:", error);
    }
  });
});

/*=============================================
ELIMINAR COLOR
=============================================*/
$(".btnEliminarColor").click(function () {
  var idColor = $(this).attr("idColor");

  var baseURL = "./colores?idColor=" + idColor;

  fncSweetAlert("confirm", "¡Está seguro de borrar el color?", baseURL);
});
