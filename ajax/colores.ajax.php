<?php

require_once "../controllers/colores.controller.php";
require_once "../models/colores.model.php";

class AjaxColores {

    /*=============================================
    EDITAR COLOR
    =============================================*/
    public $idColor;

    public function ajaxEditarColor() {
        $item = "id_color";
        $valor = $this->idColor;

        $respuesta = ControladorColores::ctrMostrarColores($item, $valor);

        echo json_encode($respuesta);
    }
}

/*=============================================
EDITAR COLOR
=============================================*/
if (isset($_POST["idColor"])) {
    $editar = new AjaxColores();
    $editar->idColor = $_POST["idColor"];
    $editar->ajaxEditarColor();
}
