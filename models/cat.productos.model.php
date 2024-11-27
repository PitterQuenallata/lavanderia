
<?php
require_once "conexion.php"; // Asegúrate de que la ruta sea correcta
class ModeloCatProductos {

      /*=============================================
  MOSTRAR CAT PRODUCTOS
  =============================================*/
  static public function mdlMostrarCatProductos($tabla, $item, $valor) {
    if ($item != null) {
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
      $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetch();
    } else {
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
      $stmt->execute();
      return $stmt->fetchAll();
    }
    $stmt = null;
  }
  /*=============================================
  INGRESAR CAT PRODUCTOS
  =============================================*/
  static public function mdlIngresarCatProductos($tabla, $datos) {
    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre_categoria_producto) VALUES (:nombre_categoria_producto)");

    $stmt->bindParam(":nombre_categoria_producto", $datos["nombre_categoria_producto"], PDO::PARAM_STR);
    

    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }

    $stmt = null;
  }

  /*=============================================
  EDITAR CAT PRODUCTOS
  =============================================*/
  static public function mdlEditarCatProductos($tabla, $datos) {
    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre_categoria_producto = :nombre_categoria_producto WHERE id_categoria_producto = :id_categoria_producto");
    $stmt->bindParam(":nombre_categoria_producto", $datos["nombre_categoria_producto"], PDO::PARAM_STR);
    $stmt->bindParam(":id_categoria_producto", $datos["idCatProductos"], PDO::PARAM_INT);


    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
    $stmt = null;
  }
  /*=============================================
  ELIMINAR CAT PRODUCTOS
  =============================================*/
  static public function mdlEliminarCatProductos($tabla, $item, $valor) {
    $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");
    $stmt->bindParam(":" . $item, $valor, PDO::PARAM_INT);

    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
    $stmt = null;
  }
}
