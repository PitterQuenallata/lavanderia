$(document).ready(function() {
  // Destruir cualquier instancia previa de DataTable
  if ($.fn.DataTable.isDataTable('#tablaCatPrendas')) {
    $('#tablaCatPrendas').DataTable().destroy();
  }

  // Inicializar DataTable con configuración en español y alineamiento de columnas
  $('#tablaCatPrendas').DataTable({
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
EDITAR CATEGORÍA DE PRENDAS
=============================================*/
$(".btnEditarCatPrenda").click(function () {
  var idCatPrenda = $(this).attr("idCatPrenda");
  var datos = new FormData();
  datos.append("idCatPrenda", idCatPrenda);

  $.ajax({
    url: "ajax/cat.prendas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      console.log("respuesta", respuesta);
      $("#idCatPrenda").val(respuesta["id_categoria_prenda"]);
      $("#editarNombreCatPrenda").val(respuesta["nombre_categoria_prenda"]);
    },
    error: function (error) {
      console.error("Error al obtener los datos de la categoría:", error);
    }
  });
});

/*=============================================
ELIMINAR CATEGORÍA DE PRENDAS
=============================================*/
$(".btnEliminarCatPrenda").click(function () {
  var idCatPrenda = $(this).attr("idCatPrenda");

  // Construir la URL correctamente con el ID de la categoría
  var baseURL = "./cat-prendas?idCatPrenda=" + idCatPrenda;

  // Llamar a la función personalizada de SweetAlert
  fncSweetAlert("confirm", "¡Está seguro de borrar la categoría?", baseURL);
});
