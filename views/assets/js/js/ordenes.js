$(document).ready(function () {
  //DATOS DEL CLIENTE
  $("#dni_cliente").on("blur", function () {
    var dni = $(this).val();

    if (dni.trim() !== "") {
      $.ajax({
        url: "ajax/ordenes.ajax.php",
        method: "POST",
        data: { dni_cliente: dni },
        dataType: "json",
        success: function (respuesta) {
          if (respuesta) {
            // Llenar los campos con los datos del cliente
            $("#nombre_cliente")
              .val(respuesta.nombre_cliente)
              .prop("readonly", true);
            $("#apellido_cliente")
              .val(respuesta.apellido_cliente)
              .prop("readonly", true);
            $("#telefono_cliente")
              .val(respuesta.telefono_cliente)
              .prop("readonly", true);
            $("#email_cliente")
              .val(respuesta.email_cliente)
              .prop("readonly", true);
            $("#direccion_cliente")
              .val(respuesta.direccion_cliente)
              .prop("readonly", true);

            // Agregar input hidden con el id_cliente
            if ($("#id_cliente").length === 0) {
              $("<input>")
                .attr({
                  type: "hidden",
                  id: "id_cliente",
                  name: "id_cliente",
                  value: respuesta.id_cliente,
                })
                .appendTo("form");
            } else {
              $("#id_cliente").val(respuesta.id_cliente);
            }
          } else {
            // Si no se encuentra el cliente, permitir edición
            $("#nombre_cliente").val("").prop("readonly", false);
            $("#apellido_cliente").val("").prop("readonly", false);
            $("#telefono_cliente").val("").prop("readonly", false);
            $("#email_cliente").val("").prop("readonly", false);
            $("#direccion_cliente").val("").prop("readonly", false);

            // Eliminar input hidden si existe
            $("#id_cliente").remove();
          }
        },
        error: function () {
          console.error("Error en la solicitud AJAX.");
        },
      });
    }
  });
});

//MODAL categoria prenda
$(document).ready(function () {
  $("#categoria_prenda").on("change", function () {
    const categoriaId = $(this).val();
    const $prendaSelect = $("#prenda");

    // Mostrar mensaje de cargando mientras se realiza la petición
    $prendaSelect.html('<option value="">Cargando prendas...</option>');

    // Realizar la solicitud AJAX
    $.ajax({
      url: "ajax/categoria.por.prenda.ajax.php",
      method: "GET",
      data: { categoria_id: categoriaId },
      dataType: "json",
      success: function (data) {
        // Limpiar y agregar las prendas al select
        $prendaSelect.html('<option value="">Selecciona una prenda</option>');
        $.each(data, function (index, prenda) {
          $prendaSelect.append(
            `<option value="${prenda.id_prenda}">${prenda.descripcion_prenda} - ${prenda.nombre_categoria_prenda}</option>`
          );
        });
      },
      error: function () {
        $prendaSelect.html('<option value="">Error al cargar prendas</option>');
      },
    });
  });
});

$(document).ready(function () {
  // Limpieza automática del modal al cerrarlo
  $("#modalAgregarPrenda").on("hidden.bs.modal", function () {
    // Restablecer los valores del formulario dentro del modal
    $(this).find("form")[0].reset();

    // Ocultar los inputs adicionales
    $("#ojalesInput").hide();
    $("#manualidadInput").hide();

    // Restablecer texto de precios
    $("#precioUnitario").text("0.00");
    $("#totalCosto").text("0.00");
  });

  // Validar cantidad mínima
  $("#cantidad").on("input", function () {
    if ($(this).val() < 1) {
      $(this).val(1);
    }
  });

  // Actualizar precio unitario y costo total
  $("#lavado, #cantidad").on("change keyup", function () {
    const costoLavado =
      parseFloat($("#lavado option:selected").data("costo")) || 0;
    const cantidad = Math.max(parseInt($("#cantidad").val()) || 0, 1); // Asegurar mínimo 1
    const total = costoLavado * cantidad;

    // Actualizar precio unitario y total
    $("#precioUnitario").text(costoLavado.toFixed(2));
    $("#totalCosto").text(total.toFixed(2));
  });

  // Agregar prenda desde el modal a la tabla
  $("#btnGuardarPrenda").on("click", function () {
    const prenda = $("#prenda option:selected").text();
    const idPrenda = $("#prenda").val();
    const color = $("#color option:selected").text();
    const idColor = $("#color").val();
    const lavado = $("#lavado option:selected").text();
    const idLavado = $("#lavado").val();
    const cantidad = $("#cantidad").val();
    const planchado = $("#planchado").is(":checked") ? "Sí" : "No";

    // Validar y obtener valor de Ojales
    let ojal = "No";
    const $cantidadOjales = $("#cantidadOjales");
    if (
      $cantidadOjales.length &&
      $cantidadOjales.val() !== null &&
      $cantidadOjales.val() !== ""
    ) {
      ojal = $cantidadOjales.val();
    }

    // Validar y obtener valor de Manualidad
    let manualidad = "No";
    const $observacion = $("#observacion");
    if (
      $observacion.length &&
      $observacion.val() !== null &&
      $observacion.val() !== ""
    ) {
      manualidad = $observacion.val();
    }

    const totalCosto = parseFloat($("#totalCosto").text()) || 0;

    // Validar campos obligatorios
    if (!idPrenda || !idColor || !idLavado || !cantidad) {
      alert("Por favor, completa todos los campos requeridos.");
      return;
    }

    // Agregar la fila a la tabla
    const nuevaFila = `
       <tr>
           <td>
               <input type="hidden" name="prendas[]" value="${idPrenda}">
               ${prenda}
           </td>
           <td>
               <input type="hidden" name="colores[]" value="${idColor}">
               ${color}
           </td>
           <td>
               <input type="hidden" name="lavados[]" value="${idLavado}">
               ${lavado}
           </td>
           <td>
               <input type="hidden" name="cantidades[]" value="${cantidad}">
               ${cantidad}
           </td>
           <td>
               <input type="hidden" name="planchados[]" value="${planchado}">
               ${planchado}
           </td>
           <td>
               <input type="hidden" name="ojales[]" value="${ojal}">
               ${ojal}
           </td>
           <td>
               <input type="hidden" name="manualidades[]" value="${manualidad}">
               ${manualidad}
           </td>
           <td class="text-end">
               <input type="hidden" name="totales[]" value="${totalCosto}">
               ${totalCosto.toFixed(2)} Bs.
           </td>
           <td class="text-center">
               <button type="button" class="btn btn-danger btn-sm btnEliminarFila">
                   <i class="fa fa-times"></i>
               </button>
           </td>
       </tr>
   `;

    $("#tablaDetallesPrendas tbody").append(nuevaFila);

    // Actualizar el total general
    actualizarTotalGeneral();

    // Cerrar el modal
    $("#modalAgregarPrenda").modal("hide");

    // Limpiar los campos del modal
    limpiarCamposModal();
  });

  // Función para limpiar los campos del modal
  function limpiarCamposModal() {
    $("#prenda").val("");
    $("#color").val("");
    $("#lavado").val("");
    $("#cantidad").val(1);
    $("#planchado").prop("checked", false);
    $("#cantidadOjales").val("");
    $("#observacion").val("");
  }

  // Función para calcular y actualizar el total general
  function actualizarTotalGeneral() {
    let totalGeneral = 0;

    // Recorrer todas las filas y sumar los costos totales
    $("#tablaDetallesPrendas tbody tr").each(function () {
      const totalFila =
        parseFloat($(this).find("input[name='totales[]']").val()) || 0;
      totalGeneral += totalFila;
    });

    // Actualizar el total general en el pie de la tabla
    $("#totalGeneral").text(`${totalGeneral.toFixed(2)} Bs.`);
  }

  // Eliminar una fila de la tabla
  $(document).on("click", ".btnEliminarFila", function () {
    $(this).closest("tr").remove();

    // Actualizar el total general después de eliminar una fila
    actualizarTotalGeneral();
  });

  // Función para codificar en Base64 compatible con Unicode
  function btoaUnicodeModern(str) {
    const utf8Bytes = new TextEncoder().encode(str); // Codifica la cadena en UTF-8
    const base64String = btoa(String.fromCharCode(...utf8Bytes));
    return base64String;
  }



  // Botón Guardar Orden
  $("#guardarOrden").click(function (e) {
    e.preventDefault(); // Evitar el comportamiento por defecto del botón

    // Validar que la tabla de prendas no esté vacía
    if ($("#tablaDetallesPrendas tbody tr").length === 0) {
      alert("Por favor, agrega al menos una prenda a la orden.");
      return;
    }

    //console.log("Guardando orden...");
    // Validar los campos principales de información general
    const dniCliente = $("#dni_cliente").val();
    const nombreCliente = $("#nombre_cliente").val();
    const apellidoCliente = $("#apellido_cliente").val();

    if (!dniCliente || !nombreCliente || !apellidoCliente) {
      alert("Por favor, completa los datos del cliente y la fecha de entrega.");
      return;
    }

    // Recopilar datos generales
    const datosGenerales = {
      id_cliente: $("#id_cliente").val(),
      dni_cliente: dniCliente,
      nombre_cliente: nombreCliente,
      apellido_cliente: apellidoCliente,
      telefono_cliente: $("#telefono_cliente").val(),
      direccion_cliente: $("#direccion_cliente").val(),
      correo_cliente: $("#email_cliente").val(),
    };
    //console.log(datosGenerales);
    // Recopilar datos de las prendas
    const prendasArray = [];
    $("#tablaDetallesPrendas tbody tr").each(function () {
      const prenda = {
         id_prenda: $(this).find("input[name='prendas[]']").val(),
         nombre_prenda: $(this).find("td").eq(0).text().trim(), // Nombre de la prenda (columna 0)
         id_color: $(this).find("input[name='colores[]']").val(),
         nombre_color: $(this).find("td").eq(1).text().trim(), // Nombre del color (columna 1)
         id_lavado: $(this).find("input[name='lavados[]']").val(),
         nombre_lavado: $(this).find("td").eq(2).text().trim(), // Nombre del tipo de lavado (columna 2)
         cantidad: $(this).find("input[name='cantidades[]']").val(),
         planchado: $(this).find("input[name='planchados[]']").val(),
         ojal: $(this).find("input[name='ojales[]']").val(),
         manualidad: $(this).find("input[name='manualidades[]']").val(),
         total: $(this).find("input[name='totales[]']").val(),
       };
      prendasArray.push(prenda);
    });
    //console.log(prendasArray);
    // Preparar los datos para la página de preorden
    const datosOrden = {
      datos_generales: datosGenerales,
      detalles_prendas: prendasArray,
    };
    //console.log(datosOrden);
    // Codificar en Base64 usando la nueva función
    const datosCodificados = btoaUnicodeModern(JSON.stringify(datosOrden));
    //console.log("Datos codificados:", datosCodificados);

    // Redirigir con los datos codificados en la URL
    window.location.href = `./preorden?orden=${encodeURIComponent(datosCodificados)}`;
  });
});
