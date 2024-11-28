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


    // Insertar el pago en la tabla `pagos`
    $idPago = ModeloOrdenes::mdlGuardarPagoEfectivo([
      "id_metodo_pago" => 2,
      "monto" => $datosGenerales["monto_pagado"],
      "estado" => $datosGenerales["monto_pendiente"] > 0 ? "Pendiente" : "Completado",
      "detalle" => "Pago inicial de la orden",
    ]);

    if (!$idPago) {
      return [
        "success" => false,
        "message" => "Error al registrar el pago."
      ];
    }
    $datosOrden = [
      "id_cliente" => (int) $datosGenerales["id_cliente"],
      "id_usuario" => (int) $_SESSION["id_usuario"], // Convertir a entero
      "id_pago" => (int) $idPago, // Convertir a entero
      "numero_orden" => uniqid("ORD-"), // Genera un número único para la orden
      "fecha_recepcion" => date("Y-m-d"), // Fecha actual
      "fecha_entrega" => $datosGenerales["fecha_entrega"],
      "monto_total_orden" => (float) $totalPrendas // Asegurarse de que sea float
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
    foreach ($detallesPrendas as $prenda) {
      $datosDetalle = [
          "id_orden" => $idOrden, // ID de la orden generada
          "id_prenda" => $prenda["id_prenda"],
          "id_color" => $prenda["id_color"],
          "id_lavado" => $prenda["id_lavado"],
          "cantidad" => $prenda["cantidad"],
          "planchado" => $prenda["planchado"],
          "ojal" => $prenda["ojal"],
          "manualidad" => $prenda["manualidad"],
      ];
  
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
    public static function ctrMostrarDetallesOrden($idOrden) {
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

}
