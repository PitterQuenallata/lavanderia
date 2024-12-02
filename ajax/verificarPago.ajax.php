<?php

require_once "../controllers/ControladorAPI.php";
require_once "../controllers/pagos.controller.php";
require_once "../models/pagos.model.php";
require_once "../models/ordenes.model.php";

// Verificar si el movimiento_id fue enviado
if (!isset($_POST['movimiento_id']) || !isset($_POST['id_orden'])) {
    echo json_encode([
        "success" => false,
        "message" => "Faltan datos necesarios para realizar la verificación."
    ]);
    exit;
}

// Datos recibidos desde AJAX
$movimiento_id = $_POST['movimiento_id'];
$id_orden = $_POST['id_orden'];

// Llamar al método del controlador
$response = ControladorPagos::ctrVerificarPagoQR($movimiento_id, $id_orden);

// Devolver la respuesta como JSON
echo json_encode($response);