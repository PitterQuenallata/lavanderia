$(document).ready(function () {
  // Destruir cualquier instancia previa de DataTable
  if ($.fn.DataTable.isDataTable("#tablaClientes")) {
    $("#tablaClientes").DataTable().destroy();
  }

  // Inicializar DataTable
  $("#tablaClientes").DataTable({
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

  /*=============================================
  EDITAR CLIENTE
  =============================================*/
  $(".btnEditarCliente").click(function () {
    var idCliente = $(this).attr("idCliente");
    var datos = new FormData();
    datos.append("idCliente", idCliente);

    $.ajax({
      url: "./ajax/clientes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        $("#idCliente").val(respuesta.id_cliente);
        $("#editarNombreCliente").val(respuesta.nombre_cliente);
        $("#editarApellidoCliente").val(respuesta.apellido_cliente);
        $("#editarTelefonoCliente").val(respuesta.telefono_cliente);
        $("#editarDireccionCliente").val(respuesta.direccion_cliente);
        $("#editarEmailCliente").val(respuesta.email_cliente);
        $("#editarDniCliente").val(respuesta.dni_cliente);
      },
    });
  });

  /*=============================================
  ELIMINAR CLIENTE
  =============================================*/
  $(".btnEliminarCliente").click(function () {
    var idCliente = $(this).attr("idCliente");
    var baseURL = "./clientes?idCliente=" + idCliente;

    fncSweetAlert(
      "confirm",
      "¡Está seguro de borrar este cliente?",
      baseURL
    );
  });
});
