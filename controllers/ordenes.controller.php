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
    //var_dump($totalPrendas);
    // var_dump($datosGenerales);
    // var_dump($detallesPrendas);
    // Validar si la suma del monto pagado y pendiente no coincide con el total de las prendas
    // Redondear ambos valores a dos decimales para comparación precisa
    if (round($datosGenerales["monto_pagado"] + $datosGenerales["monto_pendiente"], 2) !== round($totalPrendas, 2)) {
      return [
        "success" => false,
        "message" => "La suma del monto pagado y el monto pendiente no coincide con el total de las prendas."
      ];
    }


    $datosOrden = [
      "id_cliente" => (int) $datosGenerales["id_cliente"],
      "id_usuario" => (int) $_SESSION["id_usuario"],
      "numero_orden" => uniqid("ORD-"), // Genera un número único para la orden
      "fecha_recepcion" => date("Y-m-d"), // Fecha actual
      "fecha_entrega" => $datosGenerales["fecha_entrega"],
      "monto_total_orden" => (float) $totalPrendas, // Asegurarse de que sea float
      "estado_pago_orden" => $datosGenerales["monto_pendiente"] > 0 ? 0 : 1,
    ];
    //var_dump($datosOrden);
    // Insertar la orden en la tabla `ordenes`
    $idOrden = ModeloOrdenes::mdlGuardarOrden($datosOrden);

    // var_dump($idOrden);
    if (!$idOrden) {
      return [
        "success" => false,
        "message" => "Error al registrar la orden."
      ];
    }

    // Insertar el pago en la tabla `pagos`
    $pagoData = [
      "id_metodo_pago" => 2, // Por ejemplo, efectivo
      "id_orden" => $idOrden, // ID de la orden asociada
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
  

    foreach ($detallesPrendas as $prenda) {
      $datosDetalle = [
        "id_orden" => $idOrden, // ID de la orden generada
        "id_prenda" => $prenda["id_prenda"],
        "id_color" => $prenda["id_color"],
        "id_lavado" => $prenda["id_lavado"],
        "cantidad" => $prenda["cantidad"],
        // Convertir "Sí" a 1 y "No" a 0
        "planchado" => $prenda["planchado"] === "Sí" ? 1 : 0,
        "ojal" => $prenda["ojal"],
        "precio_total" => $prenda["total"],
        "manualidad" => $prenda["manualidad"],
      ];
      //var_dump($datosDetalle);
      // Guardar cada prenda por separado
      $respuestaDetalle = ModeloOrdenes::mdlGuardarDetallesPrendas($datosDetalle);

      if (!$respuestaDetalle) {
        // Si falla la inserción de alguna prenda, detener el proceso y devolver error
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
