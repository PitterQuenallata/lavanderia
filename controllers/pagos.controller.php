<?php

class ControladorPagos
{
    // Método para obtener los datos del pago por movimiento_id
    public static function ctrObtenerQrBase64($movimiento_id)
    {
        $tabla = "pagos"; // Nombre de la tabla donde se almacena el pago
        return ModeloPagos::mdlObtenerQrBase64($tabla, $movimiento_id);
    }

    /*=============================================
    Obtener datos del pago con información de la orden
    =============================================*/
    public static function ctrObtenerPagoConOrden($movimiento_id)
    {
        $tablaPagos = "pagos"; // Tabla de pagos
        $tablaOrdenes = "ordenes"; // Tabla de órdenes
        return ModeloPagos::mdlObtenerPagoConOrden($tablaPagos, $tablaOrdenes, $movimiento_id);
    }

    /*=============================================
VERIFICAR ESTADO DEL PAGO QR
=============================================*/
    public static function ctrVerificarPagoQR($movimiento_id, $id_orden)
    {
        // Llamar a la API para verificar el estado del pago
        $response = ControladorAPI::ctrVerificarEstadoQR($movimiento_id);

        if ($response["success"]) {
            $data = $response["data"];
            $estadoPago = $data["estado"];

            // Actualizar el estado del pago en la base de datos
            $actualizacion = ModeloPagos::mdlActualizarEstadoPago(
                "pagos",
                $data["movimiento_id"],
                $data["estado"],
                $data["remitente"]["nombre"],
                $data["remitente"]["banco"],
                $data["remitente"]["documento"],
                $data["remitente"]["cuenta"]
            );

            if ($actualizacion) {
                // Si el pago está completado, actualizar el estado de la orden
                if ($estadoPago === "Completado") {
                    // Obtener todos los pagos completados de la orden
                    $pagosRealizados = ModeloPagos::mdlObtenerPagosOrden($id_orden);
                    $sumaPagos = 0;

                    foreach ($pagosRealizados as $pago) {
                        $sumaPagos += floatval($pago["monto"]);
                    }

                    // Obtener el monto total de la orden
                    $detalleOrden = ModeloPagos::mdlObtenerMontoTotalOrden($id_orden);

                    if ($detalleOrden) {
                        $montoTotal = floatval($detalleOrden["monto_total_orden"]);

                        // Comparar la suma de los pagos con el monto total
                        $estadoPagoOrden = $sumaPagos >= $montoTotal ? 1 : 0;

                        // Actualizar el estado de pago de la orden
                        ModeloOrdenes::mdlActualizarEstadoPagoOrden($id_orden, $estadoPagoOrden);
                    }
                }

                return [
                    "success" => true,
                    "estado" => $estadoPago,
                    "message" => $estadoPago === "Completado"
                        ? "¡Pago confirmado exitosamente!"
                        : "El pago aún está pendiente."
                ];
            } else {
                return [
                    "success" => false,
                    "message" => "No se pudo actualizar el estado del pago en la base de datos."
                ];
            }
        } else {
            return [
                "success" => false,
                "message" => $response["message"] ?? "Error desconocido al verificar el estado del pago."
            ];
        }
    }

        /*=============================================
    COMPLETAR PAGO CON QR
    =============================================*/
    public static function ctrCompletarPagoQR($idOrden, $monto)
    {
        // Verificar que la orden exista
        $orden = ModeloOrdenes::mdlObtenerOrdenPorId($idOrden);
        if (!$orden) {
            return [
                "success" => false,
                "message" => "La orden no existe."
            ];
        }

        // Generar QR mediante la API
        $qrResponse = ControladorAPI::ctrGenerarQR($monto, "0/00:15", true);

        if (!$qrResponse["success"]) {
            return [
                "success" => false,
                "message" => "Error al generar el QR: " . $qrResponse["message"]
            ];
        }

        // Registrar el pago con QR
        $pagoData = [
            "id_metodo_pago" => 1, // QR
            "id_orden" => (int) $idOrden,
            "monto" => $monto,
            "detalle" => "Completar pago de una orden por QR",
            "estado" => "Pendiente",
            "qr_base64" => $qrResponse["qr"], // QR generado
            "movimiento_id" => $qrResponse["movimiento_id"]
        ];

        $guardarPago = ModeloOrdenes::mdlGuardarPagoQR($pagoData);

        if (!$guardarPago) {
            return [
                "success" => false,
                "message" => "Error al registrar el pago con QR en la base de datos."
            ];
        }

        // Devolver éxito junto con el QR generado
        return [
            "success" => true,
            "qr" => $qrResponse["qr"],
            "movimiento_id" => $qrResponse["movimiento_id"]
        ];
    }
}
