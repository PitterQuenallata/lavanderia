<?php
class ControladorCatProductos
{

  /*=============================================
  MOSTRAR PROVEEDORES
  =============================================*/
  static public function ctrMostrarCatProductos($item, $valor)
  {
    $tabla = "categorias_productos";
    $respuesta = ModeloCatProductos::mdlMostrarCatProductos($tabla, $item, $valor);
    return $respuesta;
  }
  /*=============================================
  CREAR PROVEEDOR
  =============================================*/
  static public function ctrCrearCatProductos()
  {
    if (isset($_POST["nombre_categoria_producto"])) {
      var_dump($_POST);
      if (
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ . ]+$/', $_POST["nombre_categoria_producto"])

      ) {

        $tabla = "categorias_productos";

        $nombreCatProducto = mb_strtolower(trim($_POST["nombre_categoria_producto"]), 'UTF-8');

        $datos = array(
          "nombre_categoria_producto" => $nombreCatProducto
        );

        $respuesta = ModeloCatProductos::mdlIngresarCatProductos($tabla, $datos);
        var_dump($respuesta);
        if ($respuesta == "ok") {
          echo '<script>
          fncSweetAlert("success", "El proveedor ha sido agregado correctamente", "cat-productos");
          </script>';
        } else {
          echo '<script>
          fncSweetAlert("error", "Error al agregar el proveedor", "");
          fncFormatInputs();
          </script>';
        }
      } else {
        echo '<script>
        fncSweetAlert("error", "¡El proveedor no puede ir vacío o llevar caracteres especiales!");
        fncFormatInputs();
        </script>';
      }
    }
  }

  /*=============================================
    EDITAR PROVEEDOR
    =============================================*/

  static public function ctrEditarCatProductos()
  {
    
    if (isset($_POST["idCatProductos"])) {

      if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ . ]+$/', $_POST["editarNombreCatProducto"])){ 

        $tabla = "categorias_productos";

        $nombreCatProducto = mb_strtolower(trim($_POST["editarNombreCatProducto"]), 'UTF-8');

        

        $datos = array(
          "idCatProductos" => $_POST["idCatProductos"],
          "nombre_categoria_producto" => $nombreCatProducto
        );

        $respuesta = ModeloCatProductos::mdlEditarCatProductos($tabla, $datos);

        if ($respuesta == "ok") {
          echo '<script>
                  fncSweetAlert("success", "La categoria ha sido actualizado correctamente", "cat-productos");
                  </script>';
        } else {
          echo '<script>
                  fncSweetAlert("error", "Error al actualizar la categoria", "");
                  fncFormatInputs();
                  </script>';
        }
      } else {
        echo '<script>
              fncSweetAlert("error", "¡La categoria no puede ir vacío o llevar caracteres especiales inválidos!", "");
              fncFormatInputs();
              </script>';
      }
    }
  }
  
/*=============================================
  ELIMINAR CAT PRODUCTOS
  =============================================*/
  public function ctrEliminarCatProductos() {
    if (isset($_GET["idCatProductos"])) {
      $tabla = "categorias_productos";
      $item = "id_categoria_producto";
      $valor = $_GET["idCatProductos"];

      $respuesta = ModeloCatProductos::mdlEliminarCatProductos($tabla, $item, $valor);

      if ($respuesta == "ok") {
        echo '<script>
        fncSweetAlert("success", "La categoria ha sido eliminado correctamente", "cat-productos");
        </script>';
      } else {
        echo '<script>
        fncSweetAlert("error", "Error al eliminar la categoria", "");
        </script>';
      }
    }
  }
}
