<?php

require_once "../controllers/cat.productos.controller.php";
require_once "../models/cat.productos.model.php";

class AjaxCatProductos {

/*=============================================
  EDITAR CAT PRODUCTOS
  =============================================*/ 

  public $idCatProductos;

  public function ajaxEditarCatProductos() {
    $item = "id_categoria_producto";
    $valor = $this->idCatProductos;

    $respuesta = ControladorCatProductos::ctrMostrarCatProductos($item, $valor);

    echo json_encode($respuesta);
  }
  /*=============================================
  ELIMINAR CAT PRODUCTOS
  =============================================*/


 
}

/*=============================================
EDITAR CAt PRODUCTOS
=============================================*/ 
if (isset($_POST["idCatProductos"])) {
  $editar = new AjaxCatProductos();
  $editar->idCatProductos = $_POST["idCatProductos"];
  $editar->ajaxEditarCatProductos();
}

?>
