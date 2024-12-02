<?php

class ControladorOrdenes
{
  /*=============================================
    MOSTRAR ÓRDENES
    =============================================*/
  public static function ctrMostrarOrdenes($item, $valor)
  {
    $tabla = "ordenes";
    $respuesta = ModeloOrdenes::mdlMostrarOrdenes($tabla, $item, $valor);
    return $respuesta;
  }

  /*=============================================
Guardar orden efectivo
=============================================*/
  public static function ctrGuardarOrdenEfectivo($datosOrden)
  {
    // Validar datos principales
    if (
      empty($datosOrden["datos_generales"]) ||
      empty($datosOrden["detalles_prendas"])
    ) {
      return [
        "success" => false,
        "message" => "Faltan datos de la orden o de las prendas."
      ];
    }

    $datosGenerales = $datosOrden["datos_generales"];
    $detallesPrendas = $datosOrden["detalles_prendas"];

    // Verificar si el cliente ya existe
    // Verificar si el cliente ya existe
    if (empty($datosGenerales["id_cliente"])) {
      $clienteData = [
        "nombre_cliente" => $datosGenerales["nombre_cliente"],
        "apellido_cliente" => $datosGenerales["apellido_cliente"],
        "telefono_cliente" => $datosGenerales["telefono_cliente"],
        "direccion_cliente" => $datosGenerales["direccion_cliente"],
        "email_cliente" => $datosGenerales["correo_cliente"],
        "dni_cliente" => $datosGenerales["dni_cliente"]
      ];

      // Buscar o crear cliente y obtener el ID
      $idCliente = ModeloOrdenes::mdlCrearClienteyRegresarId("clientes", $clienteData);

      if (!$idCliente) {
        return [
          "success" => false,
          "message" => "Error al registrar o buscar el cliente."
        ];
      }
    } else {
      $idCliente = $datosGenerales["id_cliente"];
    }




    // Calcular el total de todas las prendas
    $totalPrendas = 0;
    foreach ($detallesPrendas as $prenda) {
      $totalPrendas += floatval($prenda["total"]);
    }

    // Validar si el monto pagado supera el total de las prendas
    if ($datosGenerales["monto_pagado"] > $totalPrendas) {
      return [
        "success" => false,
        "message" => "El monto pagado no puede ser mayor al total de las prendas."
      ];
    }

    // Validar si la suma del monto pagado y pendiente no coincide con el total de las prendas
    if (round($datosGenerales["monto_pagado"] + $datosGenerales["monto_pendiente"], 2) !== round($totalPrendas, 2)) {
      return [
        "success" => false,
        "message" => "La suma del monto pagado y el monto pendiente no coincide con el total de las prendas."
      ];
    }

    // Crear la orden
    $datosOrdenInsert = [
      "id_cliente" => (int) $idCliente,
      "id_usuario" => (int) $_SESSION["id_usuario"],
      "numero_orden" => uniqid("ORD-"), // Generar número único
      "fecha_recepcion" => date("Y-m-d"), // Fecha actual
      "fecha_entrega" => $datosGenerales["fecha_entrega"],
      "monto_total_orden" => (float) $totalPrendas,
      "estado_pago_orden" => $datosGenerales["monto_pendiente"] > 0 ? 0 : 1
    ];
    // var_dump($datosOrdenInsert);

    $idOrden = ModeloOrdenes::mdlGuardarOrden($datosOrdenInsert);

    if (!$idOrden) {
      return [
        "success" => false,
        "message" => "Error al registrar la orden."
      ];
    }

    // Registrar el pago inicial
    $pagoData = [
      "id_metodo_pago" => 2, // Efectivo
      "id_orden" => $idOrden,
      "monto" => $datosGenerales["monto_pagado"],
      "detalle" => "Pago inicial de la orden",
      "estado" => "Completado"
    ];

    if (!ModeloOrdenes::mdlGuardarPagoEfectivo($pagoData)) {
      return [
        "success" => false,
        "message" => "Error al registrar el pago."
      ];
    }

    // Guardar detalles de las prendas
    foreach ($detallesPrendas as $prenda) {
      $datosDetalle = [
        "id_orden" => $idOrden,
        "id_prenda" => $prenda["id_prenda"],
        "id_color" => $prenda["id_color"],
        "id_lavado" => $prenda["id_lavado"],
        "cantidad" => $prenda["cantidad"],
        "planchado" => $prenda["planchado"] === "Sí" ? 1 : 0,
        "ojal" => $prenda["ojal"],
        "precio_total" => $prenda["total"],
        "manualidad" => $prenda["manualidad"]
      ];

      if (!ModeloOrdenes::mdlGuardarDetallesPrendas($datosDetalle)) {
        return [
          "success" => false,
          "message" => "Error al registrar los detalles de las prendas."
        ];
      }
    }

    // Si todo fue exitoso
    return [
      "success" => true,
      "message" => "Orden registrada correctamente.",
      "id_orden" => $idOrden,
      "id_cliente" => $idCliente
    ];
  }


  /*=============================================
    Registrar orden con QR
    =============================================*/
  public static function ctrRegistrarOrdenConQR($datosOrden)
  {
    // Validar datos principales
    if (
      empty($datosOrden["datos_generales"]) ||
      empty($datosOrden["detalles_prendas"])
    ) {
      return [
        "success" => false,
        "message" => "Faltan datos de la orden o de las prendas."
      ];
    }

    $datosGenerales = $datosOrden["datos_generales"];
    $detallesPrendas = $datosOrden["detalles_prendas"];

    // Verificar si el cliente ya existe
    if (empty($datosGenerales["id_cliente"])) {
      $clienteData = [
        "nombre_cliente" => $datosGenerales["nombre_cliente"],
        "apellido_cliente" => $datosGenerales["apellido_cliente"],
        "telefono_cliente" => $datosGenerales["telefono_cliente"],
        "direccion_cliente" => $datosGenerales["direccion_cliente"],
        "email_cliente" => $datosGenerales["correo_cliente"],
        "dni_cliente" => $datosGenerales["dni_cliente"]
      ];

      // Buscar o crear cliente y obtener el ID
      $idCliente = ModeloOrdenes::mdlCrearClienteyRegresarId("clientes", $clienteData);

      if (!$idCliente) {
        return [
          "success" => false,
          "message" => "Error al registrar o buscar el cliente."
        ];
      }
    } else {
      $idCliente = $datosGenerales["id_cliente"];
    }

    // Calcular el total de todas las prendas
    $totalPrendas = 0;
    foreach ($detallesPrendas as $prenda) {
      $totalPrendas += floatval($prenda["total"]);
    }

    // Validar montos
    if ($datosGenerales["monto_pagado"] > $totalPrendas) {
      return [
        "success" => false,
        "message" => "El monto pagado no puede ser mayor al total de las prendas."
      ];
    }

    if (round($datosGenerales["monto_pagado"] + $datosGenerales["monto_pendiente"], 2) !== round($totalPrendas, 2)) {
      return [
        "success" => false,
        "message" => "La suma del monto pagado y el monto pendiente no coincide con el total de las prendas."
      ];
    }

    // Crear la orden con estado de pago pendiente
    $datosOrdenInsert = [
      "id_cliente" => (int) $idCliente,
      "id_usuario" => (int) $_SESSION["id_usuario"],
      "numero_orden" => uniqid("ORD-"),
      "fecha_recepcion" => date("Y-m-d"),
      "fecha_entrega" => $datosGenerales["fecha_entrega"],
      "monto_total_orden" => (float) $totalPrendas,
      "estado_pago_orden" => 0 // Siempre pendiente inicialmente
    ];

    $idOrden = ModeloOrdenes::mdlGuardarOrden($datosOrdenInsert);

    if (!$idOrden) {
      return [
        "success" => false,
        "message" => "Error al registrar la orden."
      ];
    }

    // Generar QR mediante la API (sin detalle personalizado)
    $qrResponse = ControladorAPI::ctrGenerarQR($datosGenerales["monto_pagado"], "0/00:15", true);
    //var_dump($qrResponse);

    if (!$qrResponse["success"]) {
      return [
        "success" => false,
        "message" => "Error al generar el QR: " . $qrResponse["message"]
      ];
    }

    // Guardar detalles de las prendas
    foreach ($detallesPrendas as $prenda) {
      $datosDetalle = [
        "id_orden" => $idOrden,
        "id_prenda" => $prenda["id_prenda"],
        "id_color" => $prenda["id_color"],
        "id_lavado" => $prenda["id_lavado"],
        "cantidad" => $prenda["cantidad"],
        "planchado" => $prenda["planchado"] === "Sí" ? 1 : 0,
        "ojal" => $prenda["ojal"],
        "precio_total" => $prenda["total"],
        "manualidad" => $prenda["manualidad"]
      ];

      if (!ModeloOrdenes::mdlGuardarDetallesPrendas($datosDetalle)) {
        return [
          "success" => false,
          "message" => "Error al registrar los detalles de las prendas."
        ];
      }
    }

    // Registrar el pago con QR (al final del proceso)
    $pagoData = [
      "id_metodo_pago" => 1, // QR
      "id_orden" => (int) $idOrden, // Asegurarse de que sea un entero
      "monto" => $datosGenerales["monto_pagado"],
      "detalle" => "Pago con QR para la orden",
      "estado" => "Pendiente",
      "qr_base64" => $qrResponse["qr"], // QR generado
      "movimiento_id" => $qrResponse["movimiento_id"]
    ];
    //var_dump($qrResponse["movimiento_id"]);
    //var_dump($pagoData);
    $guardarPago = ModeloOrdenes::mdlGuardarPagoQR($pagoData);
    //var_dump($guardarPago);
    if (!$guardarPago) {
      return [
        "success" => false,
        "message" => "Error al registrar el pago con QR."
      ];
    }



    // Retornar éxito junto con el movimiento_id
    return [
      "success" => true,
      "message" => "Orden registrada correctamente.",
      "movimiento_id" => $qrResponse["movimiento_id"] // Retornar el movimiento_id
    ];
  }

  /*=============================================
    MOSTRAR DETALLES DE UNA ORDEN
    =============================================*/
  public static function ctrMostrarDetallesOrden($idOrden)
  {
    if (!empty($idOrden) && is_numeric($idOrden)) {
      // Llamar al modelo para obtener los detalles de la orden
      $detallesOrden = ModeloOrdenes::mdlMostrarDetallesOrden($idOrden);

      if ($detallesOrden) {
        return [
          "success" => true,
          "data" => $detallesOrden
        ];
      } else {
        return [
          "success" => false,
          "message" => "Error al obtener los detalles de la orden. Verifica que el ID sea válido."
        ];
      }
    } else {
      return [
        "success" => false,
        "message" => "El ID de la orden es inválido o está vacío."
      ];
    }
  }

  /*=============================================
    Actualizar estado de orden 
    =============================================*/

  public static function ctrActualizarEstadoOrden($datosOrden)
  {
    // Validar los datos obligatorios
    if (empty($datosOrden["id_orden"]) || !isset($datosOrden["estado_orden"])) {
      return [
        "success" => false,
        "message" => "Faltan datos obligatorios para actualizar el estado de la orden."
      ];
    }

    // Llamar al modelo para actualizar el estado
    $actualizado = ModeloOrdenes::mdlActualizarEstadoOrden(
      $datosOrden["id_orden"],
      $datosOrden["estado_orden"]
    );

    // Verificar si la actualización fue exitosa
    if ($actualizado) {
      return [
        "success" => true,
        "message" => "El estado de la orden se actualizó correctamente."
      ];
    } else {
      return [
        "success" => false,
        "message" => "Error al actualizar el estado de la orden."
      ];
    }
  }


  /*=============================================
Actualizar Estado Y Pagar Efectivo
=============================================*/
  public static function ctrActualizarEstadoYPagarEfectivo($datosOrden)
  {
    // Validar los datos obligatorios
    if (
      empty($datosOrden["id_orden"]) ||
      empty($datosOrden["monto_completar"]) ||
      empty($datosOrden["metodo_pago"])
    ) {
      return [
        "success" => false,
        "message" => "Faltan datos obligatorios para registrar el pago en efectivo."
      ];
    }

    // Registrar el pago en efectivo
    $pagoData = [
      "id_orden" => $datosOrden["id_orden"],
      "id_metodo_pago" => 2, // Método de pago efectivo
      "monto" => $datosOrden["monto_completar"],
      "detalle" => "Pago pendiente de la orden",
      "estado" => "Completado"
    ];

    $idPago = ModeloOrdenes::mdlGuardarPagoEfectivo($pagoData);

    if (!$idPago) {
      return [
        "success" => false,
        "message" => "Error al registrar el pago en efectivo."
      ];
    }

    // Verificar si se debe actualizar el estado de la orden
    if (!is_null($datosOrden["estado_orden"])) {
      $actualizarEstado = ModeloOrdenes::mdlActualizarEstadoOrden($datosOrden["id_orden"], $datosOrden["estado_orden"]);

      if (!$actualizarEstado) {
        return [
          "success" => false,
          "message" => "Error al actualizar el estado de la orden."
        ];
      }
    }

    // Obtener los detalles de la orden para calcular el estado de pago
    $detallesOrden = ModeloOrdenes::mdlMostrarDetallesOrden($datosOrden["id_orden"]);

    if (!$detallesOrden) {
      return [
        "success" => false,
        "message" => "No se encontraron los detalles de la orden especificada."
      ];
    }

    // Calcular la suma de los pagos realizados
    $sumaPagos = ModeloOrdenes::mdlControlPagos($datosOrden["id_orden"]);

    if ($sumaPagos === false) {
      return [
        "success" => false,
        "message" => "Error al calcular la suma de los pagos."
      ];
    }

    // Obtener el monto total de la orden
    $montoTotal = floatval($detallesOrden[0]["monto_total_orden"]);

    // Determinar el estado del pago
    $estadoPago = $sumaPagos >= $montoTotal ? 1 : 0;

    // Actualizar el estado de pago de la orden
    $actualizarEstadoPago = ModeloOrdenes::mdlActualizarEstadoPagoOrden($datosOrden["id_orden"], $estadoPago);

    if (!$actualizarEstadoPago) {
      return [
        "success" => false,
        "message" => "Error al actualizar el estado de pago de la orden."
      ];
    }

    // Si todo fue exitoso
    return [
      "success" => true,
      "message" => "El pago en efectivo se registró correctamente. El estado de la orden y el estado de pago se actualizaron correctamente."
    ];
  }
}
