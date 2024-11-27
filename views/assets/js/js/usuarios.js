$(document).ready(function() {
  // Destruir cualquier instancia previa de DataTable
  if ($.fn.DataTable.isDataTable('#tablaUsuarios')) {
    $('#tablaUsuarios').DataTable().destroy();
  }
  
  // Inicializar DataTable con configuración en español
  $('#tablaUsuarios').DataTable({
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
        "targets": [0, 1, 7, 8, 9], // Índices de las columnas que quieres centrar
        "className": "text-center"
      },
      {
        "targets": [2, 3, 4, 5, 6 ], // Índices de las columnas que quieres alinear a la izquierda
        "className": "text-left"
      }
    ]
  });

});

/*=============================================
asiganacion de usuario y contraseña segun el nombre y apellido
=============================================*/
$(document).ready(function() {
  // Escuchar cambios en los campos de nombre y apellido
  $('#nombre_usuario, #apellido_usuario').on('change', function() {
    // Obtener los valores del nombre y apellido
    var nombre = $('#nombre_usuario').val().toLowerCase();
    var apellido = $('#apellido_usuario').val().toLowerCase();

    // Generar el usuario y contraseña con la primera letra del nombre y el apellido completo
    if (nombre && apellido) {
      var usuario = nombre.charAt(0) + apellido;

      // Asignar valores a los campos de usuario y contraseña
      $('#nuevoUsuario').val(usuario).trigger('input'); // Disparar manualmente el evento `input`
      $('#password_usuario').val(usuario).trigger('input'); // Disparar manualmente el evento `input`
    }
  });
});








/*=============================================
SUBIENDO LA FOTO DEL USUARIO
=============================================*/
$(".nuevaFoto").change(function () {
  var imagen = this.files[0];

  if (!imagen) {
    return; // Salir si no hay archivo seleccionado
  }

  /*=============================================
  VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
  =============================================*/
  if (imagen.type != "image/jpeg" && imagen.type != "image/png") {
    $(".nuevaFoto").val("");
    fncSweetAlert("error", "¡La imagen debe estar en formato JPG o PNG!");
  } else if (imagen.size > 2000000) {
    $(".nuevaFoto").val("");
    fncSweetAlert("error", "¡La imagen no debe pesar más de 2MB!");
  } else {
    var datosImagen = new FileReader();
    datosImagen.readAsDataURL(imagen);

    datosImagen.onload = function (event) {
      var rutaImagen = event.target.result;
      $(".previsualizar").attr("src", rutaImagen);
    };
  }
});


/*=============================================
EDITAR USUARIO
=============================================*/
$(document).on("click", ".btnEditarUsuario", function(){
  var idUsuario = $(this).attr("idUsuario");

  var datos = new FormData();
  datos.append("idUsuario", idUsuario);

  $.ajax({
      url: "ajax/usuarios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(respuesta){
        
          
        $("#editarNombre").val(respuesta["nombre_usuario"]);
        $("#editarApellido").val(respuesta["apellido_paterno_usuario"]);
        $("#editarApellidoMaterno").val(respuesta["apellido_materno_usuario"]);
        $("#editarUsuario").val(respuesta["user_usuario"]);
        $("#editarEmail").val(respuesta["email_usuario"]);
        $("#editarPassword").val(respuesta["password_usuario"]);
        $("#editarCelular").val(respuesta["telefono_usuario"]);
        $("#fotoActual").val(respuesta["foto_usuario"]);
        $("#passwordActual").val(respuesta["password_usuario"]);

        // Establecer el valor del rol en el campo de selección
        $("#editarPerfil").val(respuesta["rol_usuario"]);

          if (respuesta["foto_usuario"] != "") {
              $(".previsualizar").attr("src", respuesta["foto_usuario"]);
          }

          // Mostrar el modal
          $("#modal-large").modal("show");
      },
      error: function (jqXHR, textStatus, errorThrown) {
          console.log("Error: " + textStatus, errorThrown);
          console.log("Response: " + jqXHR.responseText);
      }
  });
});



/*=============================================
ACTIVAR USUARIO
=============================================*/
$(document).on("click", ".btnActivar", function () {
  var idUsuario = $(this).attr("idUsuario");
  var estadoUsuario = $(this).attr("estadoUsuario");

  var datos = new FormData();
  datos.append("activarId", idUsuario);
  datos.append("activarUsuario", estadoUsuario);

  $.ajax({
    url: "ajax/usuarios.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      // Mostrar alerta de éxito si la pantalla es pequeña
      if (window.matchMedia("(max-width:767px)").matches) {
        swal({
          title: "El usuario ha sido actualizado",
          type: "success",
          confirmButtonText: "¡Cerrar!"
        }).then(function (result) {
          if (result.value) {
            window.location = "usuarios";
          }
        });
      }
    }
  });

  // Actualizar el estado del botón
  if (estadoUsuario == 0) {
    $(this).removeClass('btn-success').addClass('btn-danger').html('Inactivo').attr('estadoUsuario', 1);
  } else {
    $(this).removeClass('btn-danger').addClass('btn-success').html('Activo').attr('estadoUsuario', 0);
  }
});



/*=============================================
REVISAR SI EL USUARIO YA ESTÁ REGISTRADO
=============================================*/
$("#nuevoUsuario").change(function(){

	$(".alert").remove();

	var usuario = $(this).val();

	var datos = new FormData();
	datos.append("validarUsuario", usuario);

	 $.ajax({
	    url:"ajax/usuarios.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){

	    		$("#nuevoUsuario").parent().after('<div class="alert alert-warning">Este usuario ya existe en la base de datos</div>');

	    		$("#nuevoUsuario").val("");

	    	}

	    }

	})
})




/*=============================================
ELIMINAR USUARIO
=============================================*/
$(document).on("click", ".btnElininarUsuario", function () {
  
  var idUsuario = $(this).attr("idUsuario");
  var fotoUsuario = $(this).attr("fotoUsuario");
  var usuario = $(this).attr("usuario");
  
  //fncSweetAlert("confirm", "¡Está seguro de borrar el usuario?", "/usuarios?&idUsuario=" + idUsuario + "&usuario=" + usuario + "&fotoUsuario=" + fotoUsuario);
  // Construir la URL correcta para la eliminación del usuario
  var baseURL = "usuarios?ruta=usuarios&idUsuario=" + idUsuario;
  var queryParams = "&usuario=" + encodeURIComponent(usuario) + "&fotoUsuario=" + encodeURIComponent(fotoUsuario);

  // Llamar a la función personalizada de SweetAlert
  fncSweetAlert("confirm", "¡Está seguro de borrar el usuario", baseURL + queryParams);
  
 
});
