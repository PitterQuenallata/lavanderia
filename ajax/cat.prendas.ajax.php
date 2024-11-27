<?php

require_once "../controllers/cat.prendas.controller.php";
require_once "../models/cat.prendas.model.php";

class AjaxCatPrendas {

  /*=============================================
  EDITAR CATEGORÍA DE PRENDAS
  =============================================*/ 
  public $idCatPrenda;

  public function ajaxEditarCatPrenda() {
    $item = "id_categoria_prenda";
    $valor = $this->idCatPrenda;

    $respuesta = ControladorCatPrendas::ctrMostrarCatPrendas($item, $valor);

    echo json_encode($respuesta);
  }

  
}

/*=============================================
EDITAR CATEGORÍA DE PRENDAS
=============================================*/ 
if (isset($_POST["idCatPrenda"])) {
  $editar = new AjaxCatPrendas();
  $editar->idCatPrenda = $_POST["idCatPrenda"];
  $editar->ajaxEditarCatPrenda();
}


?>
