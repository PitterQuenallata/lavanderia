$(document).ready(function () {
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
                      $("#nombre_cliente").val(respuesta.nombre_cliente).prop("readonly", true);
                      $("#apellido_cliente").val(respuesta.apellido_cliente).prop("readonly", true);
                      $("#telefono_cliente").val(respuesta.telefono_cliente).prop("readonly", true);
                      $("#email_cliente").val(respuesta.email_cliente).prop("readonly", true);
                      $("#direccion_cliente").val(respuesta.direccion_cliente).prop("readonly", true);

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




// tabla de ordenes //////////////

$(document).ready(function () {
  // Agregar prenda desde el modal a la tabla
  $("#btnGuardarPrenda").on("click", function () {
      // Obtener los valores del modal
      var prenda = $("#prenda option:selected").text();
      var idPrenda = $("#prenda").val();
      var color = $("#color option:selected").text();
      var idColor = $("#color").val();
      var lavado = $("#lavado option:selected").text();
      var idLavado = $("#lavado").val();
      var cantidad = $("#cantidad").val();
      var planchado = $("#planchado").is(":checked") ? "Sí" : "No";
      var ojal = $("#ojal").is(":checked") ? "Sí" : "No";
      var manualidad = $("#manualidad").is(":checked") ? "Sí" : "No";

      // Validar que todos los campos requeridos estén llenos
      if (!idPrenda || !idColor || !idLavado || !cantidad) {
          alert("Por favor, completa todos los campos requeridos.");
          return;
      }

      // Agregar la fila a la tabla
      var nuevaFila = `
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
              <td class="text-center">
                  <button type="button" class="btn btn-danger btn-sm btnEliminarFila">
                      <i class="fa fa-times"></i>
                  </button>
              </td>
          </tr>
      `;

      $("#tablaDetallesPrendas tbody").append(nuevaFila);

      // Cerrar el modal
      $("#modalAgregarPrenda").modal("hide");

      // Limpiar los campos del modal
      $("#prenda").val("");
      $("#color").val("");
      $("#lavado").val("");
      $("#cantidad").val("");
      $("#planchado").prop("checked", false);
      $("#ojal").prop("checked", false);
      $("#manualidad").prop("checked", false);
  });

  // Eliminar una fila de la tabla
  $(document).on("click", ".btnEliminarFila", function () {
      $(this).closest("tr").remove();
  });
});
