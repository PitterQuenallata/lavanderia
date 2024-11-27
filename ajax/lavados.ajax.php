<?php

require_once "../controllers/lavados.controller.php";
require_once "../models/lavados.model.php";

class AjaxLavados
{
    /*=============================================
    EDITAR LAVADO
    =============================================*/
    public $idLavado;

    public function ajaxEditarLavado()
    {
        $item = "id_lavado";
        $valor = $this->idLavado;

        $respuesta = ControladorLavados::ctrMostrarLavados($item, $valor);

        echo json_encode($respuesta);
    }
}

/*=============================================
EDITAR LAVADO
=============================================*/
if (isset($_POST["idLavado"])) {
    $editar = new AjaxLavados();
    $editar->idLavado = $_POST["idLavado"];
    $editar->ajaxEditarLavado();
}
