$(document).ready(function() {
  // Destruir cualquier instancia previa de DataTable
  if ($.fn.DataTable.isDataTable('#tablaProeedores')) {
    $('#tablaProeedores').DataTable().destroy();
  }

  // Inicializar DataTable con configuración en español y alineamiento de columnas
  $('#tablaProeedores').DataTable({
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
    },
    "columnDefs": [
      {
        "targets": [0, 6], // Índices de las columnas que quieres centrar
        "className": "text-center"
      },
      {
        "targets": [1, 2, 3, 4, 5 ], // Índices de las columnas que quieres alinear a la izquierda
        "className": "text-left"
      }
    ]
  });
});




/*=============================================
EDITAR PROVEEDOR
=============================================*/
$(".btnEditarProveedores").click(function () {
  var idProveedor = $(this).attr("idProveedor");
  var datos = new FormData();
  datos.append("idProveedor", idProveedor);
  //console.log(idProveedor);
  $.ajax({
    url: "/ajax/proveedores.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      console.log("respuesta", respuesta);
      $("#editarNombreProveedor").val(respuesta["nombre_proveedor"]);
      $("#editarTelefonoProveedor").val(respuesta["telefono_proveedor"]);
      $("#editarDireccionProveedor").val(respuesta["direccion_proveedor"]);
      $("#idProveedor").val(respuesta["id_proveedor"]);
      $("#edit_nit_ci_proveedor").val(respuesta["nit_ci_proveedor"]);
      $("#edit_email_proveedor").val(respuesta["email_proveedor"]);
    },
  });
});

/*=============================================
ELIMINAR PROVEEDOR
=============================================*/
$(".btnEliminarProveedor").click(function () {
  var idProveedor = $(this).attr("idProveedor");
  
  var baseURL = "proveedores?ruta=proveedor&idProveedor=" + idProveedor;

  // Llamar a la función personalizada de SweetAlert
  fncSweetAlert("confirm", "¡Está seguro de borrar el proveedor?", baseURL);
});

