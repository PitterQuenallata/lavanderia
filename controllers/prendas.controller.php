<?php
class ControladorPrendas
{
    /*=============================================
    MOSTRAR PRENDAS POR CATEGORÍA
    =============================================*/
    static public function ctrMostrarPrendasPorCategoria($item, $valor) {
      $tabla = "prendas";
      $respuesta = ModeloPrendas::mdlMostrarPrendasPorCategoria($tabla, $item, $valor);

      return $respuesta;
  }
  /*=============================================
  MOSTRAR PRENDAS
  =============================================*/
  static public function ctrMostrarPrendas($item, $valor)
  {
    $tabla = "prendas";
    $tablaCategoria = "categorias_prendas";

    $respuesta = ModeloPrendas::mdlMostrarPrendas($tabla, $tablaCategoria, $item, $valor);

    return $respuesta;
  }

  /*=============================================
  CREAR PRENDA
  =============================================*/
  static public function ctrCrearPrenda()
  {
    if (isset($_POST["descripcion_prenda"])) {

      if (
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ . ]+$/', $_POST["descripcion_prenda"]) &&
        isset($_POST["categoria_prenda"]) && is_numeric($_POST["categoria_prenda"])
      ) {

        $tabla = "prendas";

        $datos = array(
          "descripcion_prenda" => mb_strtolower(trim($_POST["descripcion_prenda"]), 'UTF-8'),
          "id_categoria_prenda" => $_POST["categoria_prenda"]
        );

        $respuesta = ModeloPrendas::mdlIngresarPrenda($tabla, $datos);

        if ($respuesta == "ok") {
          echo '<script>
                  fncSweetAlert("success", "La prenda ha sido agregada correctamente", "prendas");
                </script>';
        } else {
          echo '<script>
                  fncSweetAlert("error", "Error al agregar la prenda", "");
                  fncFormatInputs();
                </script>';
        }
      } else {
        echo '<script>
                fncSweetAlert("error", "¡La prenda no puede llevar caracteres especiales y la categoría debe ser válida!", "");
                fncFormatInputs();
              </script>';
      }
    }
  }

  /*=============================================
  EDITAR PRENDA
  =============================================*/
  static public function ctrEditarPrenda()
  {
    if (isset($_POST["idPrenda"])) {

      if (
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ . ]+$/', $_POST["editarDescripcionPrenda"]) &&
        isset($_POST["editarCategoriaPrenda"]) && is_numeric($_POST["editarCategoriaPrenda"])
      ) {

        $tabla = "prendas";

        $datos = array(
          "idPrenda" => $_POST["idPrenda"],
          "descripcion_prenda" => mb_strtolower(trim($_POST["editarDescripcionPrenda"]), 'UTF-8'),
          "id_categoria_prenda" => $_POST["editarCategoriaPrenda"]
        );

        $respuesta = ModeloPrendas::mdlEditarPrenda($tabla, $datos);

        if ($respuesta == "ok") {
          echo '<script>
                  fncSweetAlert("success", "La prenda ha sido actualizada correctamente", "prendas");
                </script>';
        } else {
          echo '<script>
                  fncSweetAlert("error", "Error al actualizar la prenda", "");
                  fncFormatInputs();
                </script>';
        }
      } else {
        echo '<script>
                fncSweetAlert("error", "¡La prenda no puede llevar caracteres especiales y la categoría debe ser válida!", "");
                fncFormatInputs();
              </script>';
      }
    }
  }

  /*=============================================
  ELIMINAR PRENDA
  =============================================*/
  public function ctrEliminarPrenda()
  {
    if (isset($_GET["idPrenda"])) {

      $tabla = "prendas";
      $item = "id_prenda";
      $valor = $_GET["idPrenda"];

      $respuesta = ModeloPrendas::mdlEliminarPrenda($tabla, $item, $valor);

      if ($respuesta == "ok") {
        echo '<script>
                fncSweetAlert("success", "La prenda ha sido eliminada correctamente", "prendas");
              </script>';
      } else {
        echo '<script>
                fncSweetAlert("error", "Error al eliminar la prenda", "");
              </script>';
      }
    }
  }
}
