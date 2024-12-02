// Variable global para almacenar los datos decodificados de la orden
let datosOrdenGlobal = null;

// Decodificación y llenado de datos de la orden
$(document).ready(function () {
  // Función para decodificar Base64 compatible con Unicode
  function atobUnicodeModern(base64) {
    const binaryString = atob(base64);
    const utf8Bytes = Uint8Array.from(binaryString, (c) => c.charCodeAt(0));
    const decodedString = new TextDecoder().decode(utf8Bytes);
    return decodedString;
  }

  // Obtener el parámetro 'orden' de la URL
  const urlParams = new URLSearchParams(window.location.search);
  const ordenBase64 = urlParams.get("orden");

  if (ordenBase64) {
    try {
      // Decodificar el parámetro en Base64
      const jsonDecodificado = atobUnicodeModern(ordenBase64);

      // Parsear el JSON y almacenarlo en la variable global
      datosOrdenGlobal = JSON.parse(jsonDecodificado);

      // Llenar los datos del cliente en la interfaz
      $("#nombre_cliente_pO").text(datosOrdenGlobal.datos_generales.nombre_cliente || "");
      $("#apellido_cliente_pO").text(datosOrdenGlobal.datos_generales.apellido_cliente || "");
      $("#dni_cliente_pO").text(datosOrdenGlobal.datos_generales.dni_cliente || "");
      $("#telefono_cliente_pO").text(datosOrdenGlobal.datos_generales.telefono_cliente || "");
      $("#direccion_cliente_pO").text(datosOrdenGlobal.datos_generales.direccion_cliente || "");
      $("#email_cliente_pO").text(datosOrdenGlobal.datos_generales.correo_cliente || "");

      // Llenar la tabla de prendas
      const $tablaPreOrden = $("#tablaPreOrden_pO");
      datosOrdenGlobal.detalles_prendas.forEach((prenda) => {
        const fila = `
          <tr>
            <td>${prenda.nombre_prenda}</td> <!-- Nombre de la prenda -->
            <td>${prenda.nombre_color}</td> <!-- Nombre del color -->
            <td>${prenda.nombre_lavado}</td> <!-- Nombre del tipo de lavado -->
            <td>${prenda.cantidad}</td>
            <td>${prenda.planchado}</td>
            <td>${prenda.ojal}</td>
            <td>${prenda.manualidad}</td>
            <td>${parseFloat(prenda.total).toFixed(2)} Bs.</td>
          </tr>
        `;
        $tablaPreOrden.append(fila);
      });

      // Calcular el total general
      const totalGeneral = datosOrdenGlobal.detalles_prendas.reduce(
        (acc, prenda) => acc + parseFloat(prenda.total || 0),
        0
      );
      $("#totalGeneralPreOrden_pO").text(`${totalGeneral.toFixed(2)} Bs.`);
    } catch (error) {
      console.error("Error al decodificar y procesar los datos de la preorden:", error);
      alert("Ocurrió un error al procesar la preorden.");
    }
  } else {
    console.error("No se encontró el parámetro 'orden' en la URL.");
    alert("No se encontraron datos de la orden.");
  }
});



//validacion de pago inputs 
$(document).ready(function () {
  // Variables globales
  let totalGeneral = 0;

  // Obtener y calcular el total general
  const calcularTotalGeneral = () => {
    totalGeneral = parseFloat($("#totalGeneralPreOrden_pO").text().replace(" Bs.", "")) || 0;
  };

  // Validar el monto pagado y calcular el pendiente
  $("#montoPagado_pO").on("input", function () {
    const montoPagado = parseFloat($(this).val()) || 0;

    // Validaciones
    if (montoPagado > totalGeneral) {
      alert("El monto pagado no puede exceder el total general.");
      $(this).val(totalGeneral); // Ajustar el monto pagado al máximo permitido
      $("#montoPendiente_pO").val(0);
      return;
    }

    if (montoPagado < 0) {
      alert("El monto pagado no puede ser negativo.");
      $(this).val(0); // Ajustar el monto pagado al mínimo permitido
      $("#montoPendiente_pO").val(totalGeneral); // Monto pendiente será igual al total
      return;
    }

    // Calcular el monto pendiente
    const montoPendiente = totalGeneral - montoPagado;
    $("#montoPendiente_pO").val(montoPendiente.toFixed(2));
  });

  // Validación final al enviar el formulario
  $("#confirmarPagoForm").on("submit", function (e) {
    const montoPagado = parseFloat($("#montoPagado_pO").val()) || 0;
    const montoPendiente = parseFloat($("#montoPendiente_pO").val()) || 0;

    if (montoPagado <= 0) {
      alert("Debes ingresar un monto inicial a pagar.");
      e.preventDefault(); // Evitar el envío del formulario
      return;
    }

    if (montoPagado + montoPendiente !== totalGeneral) {
      alert("La suma del monto pagado y el monto pendiente debe coincidir con el total general.");
      e.preventDefault(); // Evitar el envío del formulario
      return;
    }

    alert("Formulario válido. Procediendo con la orden...");
  });

  // Inicializar el total general al cargar la página
  calcularTotalGeneral();
});

//confirmar orden
$(document).ready(function () {
  // Botón Guardar Orden
  $("#confirmarOrden_pO").click(function (e) {
    e.preventDefault(); // Evitar el envío del formulario por defecto

    // Validaciones generales
    const metodoPago = $("#metodoPago_pO").val();
    const montoPagado = parseFloat($("#montoPagado_pO").val()) || 0;
    const montoPendiente = parseFloat($("#montoPendiente_pO").val()) || 0;
    const totalGeneral = parseFloat($("#totalGeneralPreOrden_pO").text().replace(" Bs.", "")) || 0;
    const fechaEntrega = $("#fecha_entrega_pO").val();

    if (!metodoPago) {
      alert("Por favor, selecciona un método de pago válido.");
      return;
    }

    if (!fechaEntrega) {
      alert("Por favor, selecciona una fecha de entrega.");
      return;
    }

    if (montoPagado <= 0) {
      alert("Debes ingresar un monto inicial a pagar.");
      return;
    }

    if (montoPagado + montoPendiente !== totalGeneral) {
      alert("La suma del monto pagado y el monto pendiente debe coincidir con el total general.");
      return;
    }

    if (montoPagado > totalGeneral) {
      alert("El monto pagado no puede superar el total general.");
      return;
    }

    // Preparar los datos de la orden
    const datosOrden = prepararDatosOrden();

    console.log("Datos finales para guardar la orden:", datosOrden);

    if (metodoPago === "qr") {
      guardarOrdenQR(datosOrden);
    } else if (metodoPago === "efectivo") {
      guardarOrdenEfectivo(datosOrden);
    }
  });



  

// Guardar Orden con QR
function guardarOrdenQR(datosOrden) {
  console.log("Guardando orden con QR, datos:", datosOrden);

  $.ajax({
      url: "ajax/guardarOrdenQR.ajax.php", // Cambiar al endpoint que maneja QR
      method: "POST",
      data: { orden: JSON.stringify(datosOrden) }, // Enviar los datos de la orden
      dataType: "json",
      success: function (respuesta) {
          console.log("Respuesta del servidor:", respuesta);
          if (respuesta.success) {
              alert("Orden guardada exitosamente.");
              console.log("Movimiento ID:", respuesta.movimiento_id);

              // Abrir TCPDF para generar el ticket con movimiento_id
              if (respuesta.movimiento_id) {
                  window.open(`./extensiones/TCPDF-main/pdf/imprimirQR.php?movimientoId=${respuesta.movimiento_id}`, "_blank");
              }

              // Redirigir directamente a la lista de órdenes
              window.location.href = `./listOrden`;
          } else {
              alert("Error al guardar la orden con QR. Inténtalo nuevamente.");
          }
      },
      error: function (xhr, status, error) {
          console.error("Error en la solicitud AJAX:", error);
          alert("Ocurrió un error al guardar la orden. Revisa la consola para más detalles.");
      },
  });
}






  // Guardar Orden en Efectivo
  function guardarOrdenEfectivo(datosOrden) {
    console.log("Guardando orden en efectivo con los datos:", datosOrden);

    $.ajax({
      url: "ajax/guardarOrden.ajax.php",
      method: "POST",
      data: { orden: JSON.stringify(datosOrden) },
      dataType: "json",
      success: function (respuesta) {
        console.log("Respuesta del servidor:", respuesta);
        if (respuesta.success) {

          alert("Orden guardada exitosamente.");
          window.location.href = `./listOrden`;
        } else {
          alert("Error al guardar la orden. Inténtalo nuevamente.");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error en la solicitud AJAX:", error);
        alert("Ocurrió un error. Revisa la consola para más detalles.");
      },
    });
  }

  // Preparar los datos de la orden usando datosOrdenGlobal
  function prepararDatosOrden() {
    if (!datosOrdenGlobal) {
      alert("No se encontraron datos de la orden.");
      return {};
    }

    const datosGenerales = {
      ...datosOrdenGlobal.datos_generales, // Usar los datos generales decodificados
      fecha_entrega: $("#fecha_entrega_pO").val(), // Actualizar con la fecha ingresada
      monto_pagado: parseFloat($("#montoPagado_pO").val()), // Monto pagado del formulario
      monto_pendiente: parseFloat($("#montoPendiente_pO").val()), // Monto pendiente del formulario
      metodo_pago: $("#metodoPago_pO").val(), // Método de pago seleccionado
    };

    // Usar los detalles de prendas directamente desde datosOrdenGlobal
    const detallesPrendas = datosOrdenGlobal.detalles_prendas;
    console.log("Datos generales de la orden:", datosGenerales);
    return { datos_generales: datosGenerales, detalles_prendas: detallesPrendas };
  }
});



