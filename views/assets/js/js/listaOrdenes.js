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
                console.log(respuesta);
                if (respuesta.success) {
                    const orden = respuesta.data[0]; // Accede al primer objeto dentro de data
  
                    // Llenar los datos generales
                    $("#detalleNumeroOrden").text(orden.numero_orden);
                    $("#detalleCliente").text(`${orden.nombre_cliente} ${orden.apellido_cliente}`);
                    $("#detalleFechaRecepcion").text(orden.fecha_recepcion_orden);
                    $("#detalleFechaEntrega").text(orden.fecha_entrega_orden);
                    $("#detalleEstadoOrden").html(
                        orden.estado_orden === 0
                            ? '<span class="badge bg-primary">Recibido</span>'
                            : orden.estado_orden === 1
                            ? '<span class="badge bg-info">Listo para entregar</span>'
                            : '<span class="badge bg-success">Entregado</span>'
                    );
  
                    const montoTotal = parseFloat(orden.monto_total_orden).toFixed(2);
                    const montoPagado = parseFloat(orden.total_pagado).toFixed(2);
                    const montoFaltante = (montoTotal - montoPagado).toFixed(2);
  
                    $("#detalleEstadoPago").html(
                        orden.estado_pago_orden === 0
                            ? `<span class="badge bg-warning">Pendiente</span><br>
                               <small><strong>Pagado:</strong> ${montoPagado} Bs. | 
                               <strong>Falta:</strong> ${montoFaltante} Bs.</small>`
                            : orden.estado_pago_orden === 1
                            ? '<span class="badge bg-success">Pagado</span>'
                            : '<span class="badge bg-danger">Cancelado</span>'
                    );
  
                    $("#detalleMontoTotal").text(`${montoTotal} Bs.`);
  
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
                                <td>${detalle.planchado === 1 ? "Sí" : "No"}</td>
                                <td>${detalle.ojal || "Sin detalle"}</td>
                                <td>${detalle.manualidad || "Sin manualidad"}</td>
                                <td>${parseFloat(detalle.total_precio_prenda || 0).toFixed(2)} Bs.</td>
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
  
//////////////////////////  Cargar datos de la orden en el modal de editar orden  //////////////////////////
$(document).ready(function () {
    // Evento para cargar detalles al abrir el modal de editar
    $(document).on("click", ".btnEditarOrden", function () {
        const ordenId = $(this).data("id"); // Obtener el ID de la orden desde el atributo data-id

        // Realizar una solicitud AJAX para obtener los detalles de la orden
        $.ajax({
            url: "ajax/verDetalleOrden.ajax.php", // Archivo que procesará la solicitud
            method: "POST",
            data: { id_orden: ordenId },
            dataType: "json",
            success: function (respuesta) {
                console.log(respuesta);
                if (respuesta.success) {
                    const orden = respuesta.data[0]; // Accede al primer objeto dentro de data

                    // Llenar los datos generales
                    $("#idOrden").val(orden.id_orden);
                    $("#estadoPagoValorNum").val(orden.estado_pago_orden);
                    $("#actualizarNumeroOrden").text(orden.numero_orden);
                    $("#actualizarCliente").text(`${orden.nombre_cliente} ${orden.apellido_cliente}`);
                    $("#actualizarFechaRecepcion").text(orden.fecha_recepcion_orden);
                    $("#actualizarFechaEntrega").text(orden.fecha_entrega_orden);
                    $("#actualizarMontoTotal").text(`${parseFloat(orden.monto_total_orden).toFixed(2)} Bs.`);

                    // Mostrar el estado de la orden
                    $("#actualizarEstadoOrden").html(
                        orden.estado_orden === 0
                            ? '<span class="badge bg-primary">Recibido</span>'
                            : orden.estado_orden === 1
                            ? '<span class="badge bg-info">Listo para entregar</span>'
                            : '<span class="badge bg-success">Entregado</span>'
                    );

                    // Calcular montos
                    const montoTotal = parseFloat(orden.monto_total_orden).toFixed(2);
                    const montoPagado = parseFloat(orden.total_pagado).toFixed(2);
                    const montoFaltante = (montoTotal - montoPagado).toFixed(2);

                    // Mostrar el estado del pago
                    $("#actualizarEstadoPago").html(
                        orden.estado_pago_orden === 0
                            ? `<span class="badge bg-warning">Pendiente</span><br>
                               <small><strong>Pagado:</strong> ${montoPagado} Bs. | 
                               <strong>Falta:</strong> ${montoFaltante} Bs.</small>`
                            : orden.estado_pago_orden === 1
                            ? '<span class="badge bg-success">Pagado</span>'
                            : '<span class="badge bg-danger">Cancelado</span>'
                    );

                    // Llenar dinámicamente el select de estado de la orden
                    const estados = [
                        { value: 0, label: "Recibido" },
                        { value: 1, label: "Listo para entregar" },
                        { value: 2, label: "Entregado" },
                    ];

                    const $selectEstadoOrden = $("#selectEstadoOrden");
                    $selectEstadoOrden.empty(); // Limpiar opciones previas

                    estados.forEach((estado) => {
                        const selected = estado.value === orden.estado_orden ? "selected" : "";
                        $selectEstadoOrden.append(`<option value="${estado.value}" ${selected}>${estado.label}</option>`);
                    });

                    // Mostrar el estado de la orden en el encabezado
                    $("#actualizarEstadoOrden").html(
                        orden.estado_orden === 0
                            ? '<span class="badge bg-primary">Recepcionado</span>'
                            : orden.estado_orden === 1
                            ? '<span class="badge bg-info">En Proceso</span>'
                            : '<span class="badge bg-success">Entregado</span>'
                    );

                    // Mostrar u ocultar campos de pago
                    const $contenedorPago = $("#contenedorPago");
                    $contenedorPago.empty(); // Vaciar el contenedor

                    if (orden.estado_pago_orden === 0 && montoFaltante > 0) {
                        // Si el pago está pendiente y hay monto faltante, añadir campos dinámicos
                        const camposPago = `
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="checkCompletarPago">
                                <label class="form-check-label" for="checkCompletarPago"><strong>Completar Pago</strong></label>
                            </div>
                            <div id="camposPago" style="display: none;">
                                <div class="mb-3">
                                    <label for="selectMetodoPago" class="form-label"><strong>Método de Pago:</strong></label>
                                    <select id="selectMetodoPago" class="form-select" disabled>
                                        <option value="1">QR</option>
                                        <option value="2">Efectivo</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="inputMontoCompletar" class="form-label"><strong>Completar Pago:</strong></label>
                                    <input type="number" id="inputMontoCompletar" class="form-control" 
                                           placeholder="Monto a completar (Bs.)" disabled value="${montoFaltante}">
                                </div>
                            </div>
                        `;
                        $contenedorPago.append(camposPago);

                        // Evento para habilitar/deshabilitar campos de pago según el checkbox
                        $("#checkCompletarPago").on("change", function () {
                            const isChecked = $(this).is(":checked");
                            $("#camposPago").toggle(isChecked); // Mostrar u ocultar los campos
                            $("#selectMetodoPago, #inputMontoCompletar").prop("disabled", !isChecked); // Habilitar o deshabilitar
                        });
                    }
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


//////////////////////////  Actualizar estado de la orden  //////////////////////////

$(document).ready(function () {
    // Botón Guardar Cambios
    $("#btnGuardarCambios").click(function (e) {
        e.preventDefault(); // Evitar el comportamiento predeterminado del botón

        // Preparar los datos de la orden
        const completarPago = $("#checkCompletarPago").is(":checked"); // Verificar si el checkbox está marcado
        const datosOrden = prepararDatosOrden(completarPago);

        console.log("Datos finales para actualizar la orden:", datosOrden);

        // Validación: No se puede marcar "Entregado" sin completar el pago
        const valEstadoPago = parseInt($("#estadoPagoValorNum").val(), 10);
        
        if (valEstadoPago === 0) {
            if (datosOrden.estado_orden === 2 && !completarPago) {
                alert("No puedes marcar la orden como 'Entregado' sin completar el pago.");
                return; // Detener el proceso
            }
        }


        // Determinar la acción según los datos disponibles
        let action;
        if (!completarPago) {
            action = "actualizarEstado"; // Solo actualizar el estado de la orden
            actualizarOrden(action, datosOrden);
        } else if (datosOrden.metodo_pago === 2) { // 2 = Efectivo
            action = "actualizarEstadoYPagarEfectivo";
            actualizarOrden(action, datosOrden);
        } else if (datosOrden.metodo_pago === 1) { // 1 = QR
            completarPagoQR(datosOrden); // Genera QR y maneja el pago
        }
    });

    // Función para preparar los datos de la orden
    function prepararDatosOrden(completarPago) {
        const datosOrden = {
            id_orden: parseInt($("#idOrden").val(), 10) || null, // Convertir a entero o asignar null si no está presente
            estado_orden: parseInt($("#selectEstadoOrden").val(), 10) || null, // Convertir a entero o asignar null si no está presente
    

        };

        // Si el checkbox "Completar Pago" está marcado, agregar datos de pago
        if (completarPago) {
            datosOrden.metodo_pago = parseInt($("#selectMetodoPago").val(), 10) || null;
            datosOrden.monto_completar = parseFloat($("#inputMontoCompletar").val()) || 0;
        }

        return datosOrden;
    }

    // Función para realizar la solicitud AJAX
    function actualizarOrden(action, datosOrden) {
        console.log("Acción:", action, "Datos:", datosOrden);
        $.ajax({
            url: "ajax/actualizarOrden.ajax.php", // Un solo archivo para todas las acciones
            method: "POST",
            data: {
                action: action, // Enviar la acción específica
                datosOrden: datosOrden // Enviar los datos como un objeto
            },
            dataType: "json",
            success: function (respuesta) {
                if (respuesta.success) {
                    alert(respuesta.message || "La operación se realizó correctamente.");
                    $("#modalActualizarOrden").modal("hide");
                    location.reload(); // Opcional, puedes actualizar la tabla mediante AJAX
                } else {
                    alert(respuesta.message || "Error al realizar la operación.");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error al realizar la operación:", error);
                alert("Ocurrió un error al intentar realizar la operación.");
            }
        });
    }


// Función para manejar la lógica de generar QR
function completarPagoQR(datosOrden) {
    console.log("Generando QR para la orden:", datosOrden);

    $.ajax({
        url: "ajax/completarPagoQR.ajax.php", // Ruta al script backend para generar QR
        method: "POST",
        data: datosOrden,
        dataType: "json",
        success: function (respuesta) {
            if (respuesta.success) {
                alert("El QR fue generado correctamente. Escanee el QR para continuar.");
              // Abrir TCPDF para generar el ticket con movimiento_id
              if (respuesta.movimiento_id) {
                window.open(`./extensiones/TCPDF-main/pdf/imprimirQR.php?movimientoId=${respuesta.movimiento_id}`, "_blank");
            }
                // Una vez creado el QR, recargar la página para reflejar los cambios
                location.reload();
            } else {
                alert(respuesta.message || "Error al generar el QR.");
            }
        },
        error: function (xhr, status, error) {
            console.error("Error al generar el QR:", error);
            alert("Ocurrió un error al intentar generar el QR.");
        }
    });
}



    
// Evento click para el botón "Verificar Pago"
$(document).on("click", ".btnVerificarPago", function () {
    const movimientoId = $(this).data("movimiento-id"); // Obtener el movimiento_id del botón
    const idOrden = $(this).data("id-orden"); // Obtener el id de la orden

    if (!movimientoId) {
        alert("No se encontró el movimiento_id para verificar el pago.");
        return;
    }

    console.log("Iniciando verificación de pago para movimiento_id:", movimientoId);

    // Realizar la verificación del estado del pago
    $.ajax({
        url: "ajax/verificarPago.ajax.php", // Archivo AJAX que redirige al controlador
        method: "POST",
        data: { 
            movimiento_id: movimientoId,
            id_orden: idOrden // Pasamos también el ID de la orden
        },
        dataType: "json",
        success: function (respuesta) {
            console.log("Respuesta del servidor (verificación):", respuesta);

            if (respuesta.success) {
                if (respuesta.estado === "Completado") {
                    alert("¡Pago completado exitosamente!");
                    window.location.reload(); // Recargar la página para reflejar los cambios
                    // Actualizar el estado visualmente en la página (sin recargar)
                    // $(`button[data-id-orden="${idOrden}"]`).closest("td").html(
                    //     '<span class="badge bg-success">Pago Confirmado</span>'
                    // );
                } else if (respuesta.estado === "Pendiente") {
                    alert("El pago aún está pendiente.");
                }
            } else {
                alert("Error al verificar el estado del pago: " + respuesta.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud AJAX de verificación:", error);
            alert("Error al verificar el estado del pago. Por favor, intenta nuevamente.");
        },
    });
});
// Evento click para el botón "Imprimir"
$(document).on("click", ".btnImprimirOrden", function () {
    const idOrden = $(this).data("id-orden"); // Obtener el ID de la orden

    if (!idOrden) {
        alert("No se encontró el ID de la orden para imprimir.");
        return;
    }

    console.log("Imprimiendo la orden con ID:", idOrden);

    // Abrir la ventana de impresión
    window.open(`./extensiones/TCPDF-main/pdf/comprobante.php?idOrden=${idOrden}`, "_blank");
});

});
