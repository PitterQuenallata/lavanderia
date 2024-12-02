<?php

require_once "../controllers/ordenes.controller.php";
require_once "../models/ordenes.model.php";

if (isset($_POST["id_orden"])) {
    $idOrden = intval($_POST["id_orden"]); // Asegurarse de que sea un entero

    // Llamar al controlador para obtener los datos
    $respuesta = ControladorOrdenes::ctrMostrarDetallesOrden($idOrden);
    

    // Devolver la respuesta en formato JSON
    echo json_encode($respuesta);
} else {
    echo json_encode([
        "success" => false,
        "message" => "ID de orden no proporcionado."
    ]);
}
