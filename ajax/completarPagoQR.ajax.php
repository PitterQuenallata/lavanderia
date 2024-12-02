<?php
session_start();
require_once "../controllers/ordenes.controller.php";
require_once "../controllers/pagos.controller.php";
require_once "../models/pagos.model.php";

require_once "../models/ordenes.model.php";
require_once "../controllers/ControladorAPI.php";

// Verificar si se recibieron los datos necesarios
if (!isset($_POST["id_orden"]) || !isset($_POST["monto_completar"])) {
    echo json_encode([
        "success" => false,
        "message" => "Datos insuficientes para completar el pago QR."
    ]);
    exit;
}

$idOrden = $_POST["id_orden"];
$monto = $_POST["monto_completar"];

// Llamar al controlador para generar el QR y registrar el pago
$response = ControladorPagos::ctrCompletarPagoQR($idOrden, $monto);

echo json_encode($response);
