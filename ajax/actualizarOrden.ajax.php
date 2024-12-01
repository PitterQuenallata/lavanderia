<?php
session_start();
require_once "../controllers/ordenes.controller.php";
require_once "../models/ordenes.model.php";

// Verificar si se reciben los datos mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['datosOrden'])) {
    $action = $_POST['action'];
    $datosOrden = $_POST['datosOrden'];

    // Manejar las diferentes acciones
    switch ($action) {
        case "actualizarEstado":
            // Actualizar solo el estado de la orden
            $respuesta = ControladorOrdenes::ctrActualizarEstadoOrden($datosOrden);
            break;

        case "actualizarEstadoYPagarEfectivo":
            // Actualizar el estado y registrar un pago en efectivo
            $respuesta = ControladorOrdenes::ctrActualizarEstadoYPagarEfectivo($datosOrden);
            break;

        case "actualizarEstadoYPagarQR":
            // Actualizar el estado y registrar un pago por QR
            // $respuesta = ControladorOrdenes::ctrActualizarEstadoYPagarQR($datosOrden);
            break;

        default:
            $respuesta = [
                "success" => false,
                "message" => "Acción no válida."
            ];
            break;
    }

    // Enviar la respuesta como JSON
    echo json_encode($respuesta);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Solicitud no válida."
    ]);
}
