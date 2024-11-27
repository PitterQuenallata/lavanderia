<?php

require_once "../controllers/prendas.controller.php";
require_once "../models/prendas.model.php";

class AjaxPrendas {

    /*=============================================
    EDITAR PRENDA
    =============================================*/
    public $idPrenda;

    public function ajaxEditarPrenda() {
        $item = "id_prenda";
        $valor = $this->idPrenda;

        $respuesta = ControladorPrendas::ctrMostrarPrendas($item, $valor);

        echo json_encode($respuesta);
    }

}

/*=============================================
EDITAR PRENDA
=============================================*/
if (isset($_POST["idPrenda"])) {
    $editar = new AjaxPrendas();
    $editar->idPrenda = $_POST["idPrenda"];
    $editar->ajaxEditarPrenda();
}


