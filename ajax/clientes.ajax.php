<?php

require_once "../controllers/clientes.controller.php";
require_once "../models/clientes.model.php";

class AjaxClientes
{

    /*=============================================
    EDITAR CLIENTE
    =============================================*/
    public $idCliente;

    public function ajaxEditarCliente()
    {
        $item = "id_cliente";
        $valor = $this->idCliente;

        $respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);

        echo json_encode($respuesta);
    }
}

/*=============================================
EDITAR CLIENTE
=============================================*/
if (isset($_POST["idCliente"])) {
    $editar = new AjaxClientes();
    $editar->idCliente = $_POST["idCliente"];
    $editar->ajaxEditarCliente();
}
