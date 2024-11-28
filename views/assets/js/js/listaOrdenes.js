$(document).ready(function () {
  // Evento para cargar detalles al abrir el modal
  $(document).on("click", ".btnVerOrden", function () {
      const ordenId = $(this).data("id"); // Obtener el ID de la orden desde el atributo data-id

      // Realizar una solicitud AJAX para obtener los detalles de la orden
      $.ajax({
          url: "ajax/verDetalleOrden.ajax.php", // Archivo que procesará la solicitud
          method: "POST",
          data: { id_orden: ordenId },
          dataType: "json",
          success: function (respuesta) {
              if (respuesta.success) {
                  const orden = respuesta.data[0]; // Accede al primer objeto dentro de data

                  // Llenar los datos generales
                  $("#detalleNumeroOrden").text(orden.numero_orden);
                  $("#detalleCliente").text(`${orden.nombre_cliente} ${orden.apellido_cliente}`);
                  $("#detalleFechaRecepcion").text(orden.fecha_recepcion_orden);
                  $("#detalleFechaEntrega").text(orden.fecha_entrega_orden);
                  $("#detalleEstadoOrden").html(
                      orden.estado_orden === 0
                          ? '<span class="badge bg-primary">Recepcionado</span>'
                          : orden.estado_orden === 1
                          ? '<span class="badge bg-info">En Proceso</span>'
                          : '<span class="badge bg-success">Entregado</span>'
                  );
                  $("#detalleEstadoPago").html(
                      orden.estado_pago === "Pendiente"
                          ? '<span class="badge bg-warning">Pendiente</span>'
                          : orden.estado_pago === "Completado"
                          ? '<span class="badge bg-success">Completado</span>'
                          : '<span class="badge bg-danger">Cancelado</span>'
                  );
                  $("#detalleMontoTotal").text(`${parseFloat(orden.monto_total_orden).toFixed(2)} Bs.`);

                  // Llenar la tabla de detalles de las prendas
                  const $detallePrendas = $("#detallePrendas");
                  $detallePrendas.empty();

                  respuesta.data.forEach((detalle, index) => {
                      const fila = `
                          <tr>
                              <td>${index + 1}</td>
                              <td>${detalle.descripcion_prenda || "Sin descripción"}</td>
                              <td>${detalle.nombre_color || "Sin color"}</td>
                              <td>${detalle.descripcion_lavado || "Sin lavado"}</td>
                              <td>${detalle.cantidad}</td>
                              <td>${detalle.planchado === "1" ? "Sí" : "No"}</td>
                              <td>${detalle.ojal || "Sin detalle"}</td>
                              <td>${detalle.manualidad || "Sin manualidad"}</td>
                              <td>${parseFloat(detalle.total || 0).toFixed(2)} Bs.</td>
                          </tr>
                      `;
                      $detallePrendas.append(fila);
                  });
              } else {
                  alert(respuesta.message || "No se pudo cargar los detalles de la orden.");
              }
          },
          error: function (xhr, status, error) {
              console.error("Error al cargar los detalles:", error);
              alert("Ocurrió un error al cargar los detalles de la orden.");
          }
      });
  });
});
