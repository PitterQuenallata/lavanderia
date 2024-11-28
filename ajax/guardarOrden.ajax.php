<?php
session_start();
require_once "../controllers/ordenes.controller.php";
require_once "../models/ordenes.model.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["orden"])) {
        $datosOrden = json_decode($_POST["orden"], true);

        if ($datosOrden) {
            // Llamar al controlador para procesar los datos de la orden
            $respuesta = ControladorOrdenes::ctrGuardarOrdenEfectivo($datosOrden);

            // Enviar la respuesta como JSON al cliente
            echo json_encode([
                "success" => $respuesta["success"],
                "message" => $respuesta["message"]
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Datos de la orden inválidos."
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "No se recibió la orden."
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Método no permitido."
    ]);
}

