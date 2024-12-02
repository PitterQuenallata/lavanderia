<?php
session_start();
require_once "../controllers/ordenes.controller.php";
require_once "../models/ordenes.model.php";
require_once "../controllers/ControladorAPI.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decodificar los datos enviados desde el frontend
    $datosOrden = isset($_POST['orden']) ? json_decode($_POST['orden'], true) : null;

    if (!$datosOrden) {
        echo json_encode([
            "success" => false,
            "message" => "No se enviaron los datos de la orden."
        ]);
        exit;
    }

    // Obtener el ID del usuario desde la sesión
    $idUsuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;

    if (!$idUsuario) {
        echo json_encode([
            "success" => false,
            "message" => "No se encontró información del usuario en la sesión."
        ]);
        exit;
    }

    // Añadir el ID del usuario a los datos de la orden
    $datosOrden['id_usuario'] = $idUsuario;

    // Llamar al controlador para registrar la orden con QR
    $respuesta = ControladorOrdenes::ctrRegistrarOrdenConQR($datosOrden);
    
    if ($respuesta['success']) {
        echo json_encode([
            "success" => true,
            "movimiento_id" => $respuesta['movimiento_id'] // Retorna el movimiento_id
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => $respuesta['message'] ?? "Error al guardar la orden."
        ]);
    }
}
