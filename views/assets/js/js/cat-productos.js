$(document).ready(function() {
  // Destruir cualquier instancia previa de DataTable
  if ($.fn.DataTable.isDataTable('#tablaCatProductos')) {
    $('#tablaCatProductos').DataTable().destroy();
  }

  // Inicializar DataTable con configuración en español y alineamiento de columnas
  $('#tablaCatProductos').DataTable({
    "language": {
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ningún dato disponible en esta tabla",
      "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix": "",
      "sSearch": "Buscar:",
      "sUrl": "",
      "sInfoThousands": ",",
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
EDITAR CAT PRODUCTOS
=============================================*/
$(".btnEditarCatProducto").click(function () {
  var idCatProductos = $(this).attr("idCatProductos");
  var datos = new FormData();
  datos.append("idCatProductos", idCatProductos);
  //console.log(idCatProductos);
  $.ajax({
    url: "/ajax/cat-productos.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      console.log("respuesta", respuesta);
      $("#idCatProductos").val(respuesta["id_categoria_producto"]);
      $("#editarNombreCatProducto").val(respuesta["nombre_categoria_producto"]);


    },
  });
});

/*=============================================
ELIMINAR CAT PRODUCTOS
=============================================*/
$(".btnEliminarCatProducto").click(function () {
  var idCatProductos = $(this).attr("idCatProductos");
  
  var baseURL = "cat-productos?ruta=catproduct&idCatProductos=" + idCatProductos;

  // Llamar a la función personalizada de SweetAlert
  fncSweetAlert("confirm", "¡Está seguro de borrar la categoria?", baseURL);
});

