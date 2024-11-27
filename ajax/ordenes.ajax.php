<?php

require_once "../controllers/clientes.controller.php";
require_once "../models/clientes.model.php";

class AjaxOrdenes {
    
    public $dni_cliente;

    public function ajaxBuscarClientePorDNI() {
        $item = "dni_cliente";
        $valor = $this->dni_cliente;

        $respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);

        echo json_encode($respuesta);
    }
}

if (isset($_POST["dni_cliente"])) {
    $cliente = new AjaxOrdenes();
    $cliente->dni_cliente = $_POST["dni_cliente"];
    $cliente->ajaxBuscarClientePorDNI();
}
