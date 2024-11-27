<?php

require_once "../controllers/proveedores.controller.php";
require_once "../models/proveedores.model.php";

class AjaxProveedores {

/*=============================================
  EDITAR PROVEEDOR
  =============================================*/ 

  public $idProveedor;

  public function ajaxEditarProveedor() {
    $item = "id_proveedor";
    $valor = $this->idProveedor;

    $respuesta = ControladorProveedores::ctrMostrarProveedores($item, $valor);

    echo json_encode($respuesta);
  }
  /*=============================================
  ELIMINAR PROVEEDOR
  =============================================*/


 
}

/*=============================================
EDITAR PROVEEDOR
=============================================*/ 
if (isset($_POST["idProveedor"])) {
  $editar = new AjaxProveedores();
  $editar->idProveedor = $_POST["idProveedor"];
  $editar->ajaxEditarProveedor();
}

?>
