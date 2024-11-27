$(document).ready(function () {
  // Destruir cualquier instancia previa de DataTable
  if ($.fn.DataTable.isDataTable('#tablaPrendas')) {
    $('#tablaPrendas').DataTable().destroy();
  }

  // Inicializar DataTable con configuración en español
  $('#tablaPrendas').DataTable({
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
EDITAR PRENDA
=============================================*/
$(".btnEditarPrenda").click(function () {
  var idPrenda = $(this).attr("idPrenda");
  var datos = new FormData();
  datos.append("idPrenda", idPrenda);

  $.ajax({
    url: "ajax/prendas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      console.log("respuesta", respuesta);
      $("#idPrenda").val(respuesta["id_prenda"]);
      $("#editarDescripcionPrenda").val(respuesta["descripcion_prenda"]);
      $("#editarCategoriaPrenda").val(respuesta["id_categoria_prenda"]);
    },
    error: function (error) {
      console.error("Error al obtener los datos de la prenda:", error);
    }
  });



/*=============================================
ELIMINAR PRENDA
=============================================*/
$(".btnEliminarPrenda").click(function () {
  var idPrenda = $(this).attr("idPrenda");

  // Construir la URL correctamente con el ID de la prenda
  var baseURL = "./prendas?idPrenda=" + idPrenda;

  // Llamar a la función personalizada de SweetAlert
  fncSweetAlert("confirm", "¡Está seguro de borrar la prenda?", baseURL);
});


});