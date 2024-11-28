<?php

require_once "../controllers/prendas.controller.php";
require_once "../models/prendas.model.php";

class AjaxPrendas {

    public $idCategoriaPrenda;

    public function ajaxObtenerPrendasPorCategoria() {
        $item = "id_categoria_prenda";
        $valor = $this->idCategoriaPrenda;

        $respuesta = ControladorPrendas::ctrMostrarPrendasPorCategoria($item, $valor);

        echo json_encode($respuesta);
    }
}

/*=============================================
OBTENER PRENDAS POR CATEGORÍA
=============================================*/
if (isset($_GET["categoria_id"])) {
    $prendasPorCategoria = new AjaxPrendas();
    $prendasPorCategoria->idCategoriaPrenda = $_GET["categoria_id"];
    $prendasPorCategoria->ajaxObtenerPrendasPorCategoria();
}
